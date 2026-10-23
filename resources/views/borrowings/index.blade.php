@extends('layouts.app')

@section('title', 'Borrowings')

@section('page-title', 'Borrowings')

@section('content')

<style>
    /* ===== BORROWINGS PAGE ===== */

    .borrowings-page {
        width: 100%;
    }

    /* ---------- PAGE HEADER ---------- */

    .borrowings-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        gap: 20px;
    }

    /* Search */

    .search-form {
        display: flex;
        gap: 8px;
    }

    .search-form input {
        flex:1;
        width: 240px;
        padding: 11px 14px;
        border: 1px solid #D8C8B7;
        border-radius: 10px;
        background-color: #F8F2E7;
        color: #3F4438;
        outline: none;
        font-size: 0.95rem;
        transition: 0.2s ease;
    }

    .search-form input:focus {
        border-color: #B87586;
        box-shadow: 0 0 0 3px rgba(184, 117, 134, 0.12);
    }

    .search-form button {
        padding: 11px 18px;
        border: none;
        border-radius: 10px;
        background-color: #D99AA8;
        color: #fffaf5;
        font-weight: 600;
        cursor: pointer;
        transition: 0.25s ease;
    }

    .search-form button:hover {
        background-color: #B87586;
    }


    /* Borrow Book */

    .borrow-button {
        display: inline-block;
        padding: 11px 20px;
        background-color: #6F8060;
        color: #F8F2E7;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        transition: 0.25s ease;
        white-space: nowrap;
    }

    .borrow-button:hover {
        background-color: #5F7053;
        transform: translateY(-1px);
    }


    /* ---------- TABLE ---------- */

    .borrowings-table-container {
        background-color: #F8F2E7;
        border-radius: 16px;
        border: 1px solid #E2D6C7;
        box-shadow: 0 8px 25px rgba(63, 68, 56, 0.07);
        overflow: hidden;
    }

    .borrowings-table {
        width: 100%;
        border-collapse: collapse;
    }

    .borrowings-table thead {
        background-color: #6F8060;
        color: #F8F2E7;
    }

    .borrowings-table th {
        padding: 15px 16px;
        text-align: left;
        font-size: 0.88rem;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .borrowings-table td {
        padding: 15px 16px;
        border-bottom: 1px solid #E8DED2;
        font-size: 0.94rem;
    }

    .borrowings-table tbody tr {
        transition: 0.2s ease;
    }

    .borrowings-table tbody tr:hover {
        background-color: #F5E8E9;
    }

    .borrowings-table tbody tr:last-child td {
        border-bottom: none;
    }


    /* ---------- MEMBER ---------- */

    .member-name {
        font-weight: 600;
        color: #593C33;
    }


    /* ---------- BOOK ---------- */

    .book-name {
        color: #6F8060;
        font-weight: 600;
    }


    /* ---------- DATES ---------- */

    .borrowed-date {
        color: #777A69;
    }

    .due-date {
        color: #8F5967;
        font-weight: 600;
    }


    /* ---------- EMPTY STATE ---------- */

    .empty-state {
        text-align: center;
        padding: 35px 20px !important;
        color: #777A69 !important;
    }

    /* ---------- BORROWING ID ---------- */

    .borrowing-id {
        font-weight: 700;
        color: #6F8060;
    }


    /* ---------- STATUS ---------- */

    .status {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.82rem;
    font-weight: 700;
    white-space: nowrap;
    }

    .status.borrowed {
    background-color: #E4EBD9;
    color: #5F7053;
    }

    .status.overdue {
    background-color: #F5DDE1;
    color: #8F5967;
    }

    .status.returned {
    background-color: #E8D5B9;
    color: #765035;
    }


     /* Edit button */
    .edit-link {
        display: inline-block;
        padding: 7px 13px;
        background-color: #E8C1C8;
        color: #7E5360;
        text-decoration: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: 0.2s ease;
    }

    .edit-link:hover {
        background-color: #D99AA8;
        color: #fffaf5;
    }

</style>

<div class="borrowings-page">


<!-- PAGE HEADER -->

<div class="borrowings-header">

    <form
        action="{{ route('borrowings.index') }}"
        method="GET"
        class="search-form"
    >

        <input
            type="text"
            name="search"
            placeholder="Search borrowings..."
            value="{{ request('search') }}"
        >

        <button type="submit">
            Search
        </button>

    </form>


    <a
        href="{{ route('borrowings.create') }}"
        class="borrow-button"
    >
        + Borrow Book
    </a>

</div>


<!-- BORROWINGS TABLE -->

<div class="borrowings-table-container">

    <table class="borrowings-table">

        <thead>
            <th>Borrowing ID</th>
            <th>Member</th>
            <th>Book</th>
            <th>Borrowed</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Actions</th>
        </thead>


        <tbody>

            @forelse ($borrowings as $borrowing)

                <tr>

                    <td> 
                        <span class="borrowing-id">
                            {{ $borrowing->borrowing_id }}
                        </span>
                        
                    </td>

                    <td>
                        <span class="member-name">
                            {{ $borrowing->member->member_name }}
                        </span>
                    </td>

                    <td>
                        <span class="book-name">
                            {{ $borrowing->book->title }}
                        </span>
                    </td>

                    <td>
                        <span class="borrowed-date">
                           {{ $borrowing->borrowed_at->format(' d M Y') }}
                        </span>
                    </td>

                    <td>
                        <span class="due-date">
                            {{ $borrowing->due_date->format(' d M Y') }}
                        </span>
                    </td>

                    <td>
                        <span class="status {{ strtolower($borrowing->status) }}">
                            {{ $borrowing->status }}
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('borrowings.edit', $borrowing->id) }}" class="edit-link">
                            Edit
                        </a>
                    </td>
                    
                </tr>


            @empty

                <tr>
                    <td colspan="4" class="empty-state">
                        No borrowing records yet.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>


</div>

@endsection
