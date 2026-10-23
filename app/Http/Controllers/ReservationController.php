<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Member;
use App\Models\Book;
use App\Models\Borrowing;
//Because it also has connection to meber and book

use Illuminate\Http\Request;


class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $reservations = Reservation::with(['member', 'book'])
            ->when($search, function ($query) use ($search) {
                $query->where('reservation_id', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('member', function ($q) use ($search) {
                        $q->where('member_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('book', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    });
            })
            ->oldest('reserved_at') //1
            ->get(); //1

        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $members = Member::orderBy('member_name')->get();

        $books = Book::where('available_copies', 0)
            ->orderBy('title')
            ->get();

        return view('reservations.create', compact('members', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,member_id',
            'book_id' => 'required|exists:books,book_id',
        ]);

        $book = Book::where('book_id', $request->book_id)->firstOrFail();

        if ($book->available_copies > 0) {
            return back()->with('error', 'This book is currently available. It can be borrowed instead.');
        } //If the book has a copy available, we don't allow a reservation.

        $lastReservation = Reservation::latest('id')->first();

        $nextNumber = $lastReservation
            ? ((int) substr($lastReservation->reservation_id, 1)) + 1
            : 1;

        $reservationId = 'R' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        Reservation::create([
            'reservation_id' => $reservationId,
            'member_id' => $request->member_id,
            'book_id' => $request->book_id,
            'reserved_at' => now(),
            'status' => 'Pending',
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Book reserved successfully.'); //pel yg finish add reserve hz vea tv main page vinh 
    }

    //For when you click fullfilled button it automatically create borrow info
    public function fulfill(Reservation $reservation)
    {
        // Only Ready reservations can be fulfilled
        if ($reservation->status !== 'Ready') {
            return back()->with(
                'error',
                'This reservation is not ready to be fulfilled.'
            );
        }

        // Create the borrowing
        $borrowing = Borrowing::create([
            'borrowing_id' => 'B' . str_pad(
                ((int) substr(
                    Borrowing::latest('id')->first()?->borrowing_id ?? 'B000',
                    1
                )) + 1,
                3,
                '0',
                STR_PAD_LEFT
            ),

            // Use the real database IDs
            'member_id' => $reservation->member->id,
            'book_id' => $reservation->book->id,

            'borrowed_at' => now(),
            'due_date' => now()->addDays(7),
        ]);

        // The reserved book is now borrowed
        $reservation->book->decrement('available_copies');

        // Mark reservation as fulfilled
        $reservation->update([
            'status' => 'Fulfilled',
            'fulfilled_at' => now(),
        ]);

        return redirect()->route('reservations.index')
            ->with(
                'success',
                'Reservation fulfilled and borrowing created successfully.'
            );
    }
}
