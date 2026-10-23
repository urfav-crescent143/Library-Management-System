<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;
use App\Models\Fine;

class DashboardController extends Controller
{
    public function index()
    {
        // Dashboard statistics
        $totalBooks = Book::count();

        $activeMembers = Member::where('status', 'Active')->count();

        $borrowedBooks = Borrowing::whereNull('returned_at')->count();

        $overdueBooks = Borrowing::whereNull('returned_at')
            ->whereDate('due_date', '<', now())
            ->count();

        $unpaidFines = Fine::where('status', 'Unpaid')
            ->sum('amount');

        // Urgent overdue books
        $overdueBorrowings = Borrowing::with(['member', 'book'])
            ->whereNull('returned_at')
            ->whereDate('due_date', '<', now())
            ->orderBy('due_date', 'asc')
            ->take(5)
            ->get();

        // Library overview
        $totalCopies = Book::sum('total_copies');

        $availableCopies = Book::sum('available_copies');

        $borrowedCopies = $totalCopies - $availableCopies;

        return view('dashboard.index', compact(
            'totalBooks',
            'activeMembers',
            'borrowedBooks',
            'overdueBooks',
            'unpaidFines',
            'overdueBorrowings',
            'totalCopies',
            'availableCopies',
            'borrowedCopies'
        ));
    }
}