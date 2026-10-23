<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $borrowings = Borrowing::with(['member', 'book'])
            ->whereNull('returned_at')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('borrowing_id', 'like', '%' . $search . '%')
                        ->orWhereHas('member', function ($query) use ($search) {
                            $query->where('member_name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('book', function ($query) use ($search) {
                            $query->where('title', 'like', '%' . $search . '%');
                        });
                });
            })
            ->get();

        return view('returns.index', compact('borrowings'));
    }

    public function update(Borrowing $borrowing)
    {
        // 1. Mark the book as returned
        $borrowing->returned_at = now();

        // 2. Give the book back to the available copies
        $borrowing->book->increment('available_copies');

        // 3. Save the return
        $borrowing->save();

        // 4. Check for the oldest pending reservation for this book-Find the oldest Pending reservation for the book that was just returned.
        $reservation = Reservation::where('book_id', $borrowing->book->book_id) 
            ->where('status', 'Pending')
            ->orderBy('reserved_at', 'asc')
            ->first();

        // 5. If there is a pending reservation, mark it as Ready
        if ($reservation) {
            $reservation->update([
                'status' => 'Ready',
            ]);
        }

        // 6. Calculate overdue days
        $overdueDays = 0;

        if ($borrowing->returned_at->gt($borrowing->due_date)) {
            $overdueDays = $borrowing->due_date->diffInDays($borrowing->returned_at);
        }

        // 7. If overdue, create a Fine
        if ($overdueDays > 0) {
            $borrowing->fine()->create([
                'overdue_days' => $overdueDays,
                'amount' => $overdueDays * 0.50,
                'status' => 'Unpaid',
            ]);
        }

        return redirect()->route('returns.index');
    }
}