<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $members = Member::query()
            ->when($search, function ($query, $search) {
                $query->where('member_id', 'like', "%{$search}%")
                    ->orWhere('member_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })
            ->get();

        return view('members.index', compact('members'));
    }
    public function create()
    {
        return view('members.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'join_date' => 'required|date',
            'status' => 'required|in:Active,Inactive',
        ]);

        // Get the latest member
        $lastMember = Member::orderBy('id', 'desc')->first();

        // Generate the next Member ID
        if ($lastMember) {
            $number = (int) substr($lastMember->member_id, 1);
            $nextNumber = $number + 1;
        } else {
            $nextNumber = 1;
        }

        $validated['member_id'] = 'M' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        Member::create($validated);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member added successfully.');
    }
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }
    public function update(Request $request, Member $member)
{
    $validated = $request->validate([
    'member_name' => 'required',
    'email' => 'nullable|email',
    'phone' => 'nullable',
    'join_date' => 'required|date',
    'status' => 'required|in:Active,Inactive',
    ]);

    $member->update($validated);

    return redirect()->route('members.index');
}
}
