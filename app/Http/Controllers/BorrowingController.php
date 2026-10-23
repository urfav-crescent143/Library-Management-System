<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $borrowings = Borrowing::with(['member', 'book'])
            ->when($search, function ($query) use ($search) {
                $query->where('borrowing_id', 'like', '%' . $search . '%')
                    ->orWhereHas('member', function ($query) use ($search) {
                        $query->where('member_name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('book', function ($query) use ($search) {
                        $query->where('title', 'like', '%' . $search . '%');
                    });
            })
            ->get();

        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $members = \App\Models\Member::all();

        $books = \App\Models\Book::where('available_copies', '>', 0)->get();

        return view('borrowings.create', compact('members', 'books'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'borrowed_at' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrowed_at',
        ]);

        // STEP 1: Check the member first
        $member = Member::findOrFail($request->member_id);

        if ($member->status !== 'Active') {
            return back()
                ->withInput()
                ->with('error', 'Borrowing unsuccessful! This member is inactive.');
        }

        // STEP 2: Check whether the book is available
        $book = Book::findOrFail($request->book_id);

        if ($book->available_copies <= 0) {
            return back()
                ->withInput()
                ->with('error', 'This book is not available.');
        }

        // STEP 3: Generate Borrowing ID
        $lastBorrowing = Borrowing::latest('id')->first();

        $nextNumber = $lastBorrowing ? $lastBorrowing->id + 1 : 1;

        $borrowingId = 'BR' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // STEP 4: Create the borrowing record
        Borrowing::create([
            'borrowing_id' => $borrowingId,
            'member_id' => $request->member_id,
            'book_id' => $request->book_id,
            'borrowed_at' => $request->borrowed_at,
            'due_date' => $request->due_date,
        ]);

        // STEP 5: Decrease available copies
        $book->decrement('available_copies');

        return redirect()
            ->route('borrowings.index')
            ->with('success', 'Book borrowed successfully.');
    }

    //For Edit actions
    public function edit(Borrowing $borrowing)
    {
        $members = \App\Models\Member::all();

        return view('borrowings.edit', compact('borrowing', 'members'));
    }

    public function update(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'borrowed_at' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrowed_at',
        ]);

        $borrowing->update([
            'member_id' => $request->member_id,
            'borrowed_at' => $request->borrowed_at,
            'due_date' => $request->due_date,
        ]);

        return redirect()
            ->route('borrowings.index')
            ->with('success', 'Borrowing updated successfully.');
    }
}