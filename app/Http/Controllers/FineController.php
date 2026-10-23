<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;

class FineController extends Controller 
{
    public function index(Request $request)
    {
        $search = $request->search;

        $fines = Fine::with(['borrowing.member', 'borrowing.book']) //Get all fines, and also get the borrowing and member connected to each fine.

        //Give me all fines, but if the user searched something, find it by Fine ID, Borrowing ID, Member, or Book.
            ->when($search, function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                    ->orWhereHas('borrowing', function ($query) use ($search) {
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

        return view('fines.index', compact('fines'));
    }

    public function pay(Fine $fine) //cause when you clciked paid
    {
        if ($fine->status === 'Unpaid') {
            $fine->update([
                'status' => 'Paid',
                'paid_at' => now(),
            ]);
        }

        return redirect()->route('fines.index');
    }
}