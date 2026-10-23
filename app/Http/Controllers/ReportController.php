<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\Category;
use App\Models\Fine;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $currentYear = Carbon::now()->year; //Laravel automatically get the current year

        // 1. Borrowing Trends
        $monthlyBorrowings = Borrowing::whereYear('borrowed_at', $currentYear)
            ->selectRaw('MONTH(borrowed_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $borrowingTrends = [];

        for ($month = 1; $month <= 12; $month++) {
            $borrowingTrends[] = [
                'month' => Carbon::create()->month($month)->format('M'),
                'total' => $monthlyBorrowings[$month] ?? 0,
            ];
        }


        // 2. Most Borrowed Books
        $mostBorrowedBooks = Borrowing::with('book')
            ->whereYear('borrowed_at', $currentYear)
            ->selectRaw('book_id, COUNT(*) as total')
            ->groupBy('book_id')
            ->orderByDesc('total')
            ->take(10) //for top : mean give 10 results 
            ->get();


        // 3. Most Active Members
        $mostActiveMembers = Borrowing::with('member')
            ->whereYear('borrowed_at', $currentYear)
            ->selectRaw('member_id, COUNT(*) as total')
            ->groupBy('member_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();


        // 4. Popular Categories
        $popularCategories = Borrowing::join(
                'books',
                'borrowings.book_id',
                '=',
                'books.id'
            )
            ->join(
                'categories',
                'books.category_id',
                '=',
                'categories.id'
            )
            ->whereYear('borrowings.borrowed_at', $currentYear)
            ->selectRaw('categories.name, COUNT(*) as total')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total')
            ->take(5)
            ->get();


        // 5. Overdue Analysis
        $monthlyOverdues = Borrowing::whereYear('due_date', $currentYear)
            ->whereDate('due_date', '<', now())
            ->selectRaw('MONTH(due_date) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $overdueAnalysis = [];

        for ($month = 1; $month <= 12; $month++) {
            $overdueAnalysis[] = [
                'month' => Carbon::create()->month($month)->format('M'),
                'total' => $monthlyOverdues[$month] ?? 0,
            ];
        }


        // 6. Fine Analysis
        $monthlyFines = Fine::whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $fineAnalysis = [];

        for ($month = 1; $month <= 12; $month++) {
            $fineAnalysis[] = [
                'month' => Carbon::create()->month($month)->format('M'),
                'total' => $monthlyFines[$month] ?? 0,
            ];
        }

        $totalFines = Fine::whereYear('created_at', $currentYear)
            ->sum('amount');

        $paidFines = Fine::whereYear('created_at', $currentYear)
            ->where('status', 'Paid')
            ->sum('amount');

        $unpaidFines = Fine::whereYear('created_at', $currentYear)
            ->where('status', 'Unpaid')
            ->sum('amount');


        // 7. Collection Summary
        $collectionSummary = Category::withCount('books')
            ->get()
            ->map(function ($category) {
                $category->total_copies = Book::where(
                    'category_id',
                    $category->id
                )->sum('total_copies');

                return $category;
            });


        // 8. Low-Circulation Books
        $lowCirculationBooks = Book::withCount([
            'borrowings' => function ($query) use ($currentYear) {
                $query->whereYear('borrowed_at', $currentYear);
            }
        ])
        ->orderBy('borrowings_count')  //Sort by borrowing count from smallest to largest → take the first 5.
        ->take(5)
        ->get();


        return view('reports.index', compact(
            'currentYear',
            'borrowingTrends',
            'mostBorrowedBooks',
            'mostActiveMembers',
            'popularCategories',
            'overdueAnalysis',
            'fineAnalysis',
            'totalFines',
            'paidFines',
            'unpaidFines',
            'collectionSummary',
            'lowCirculationBooks'
        ));
    }
}