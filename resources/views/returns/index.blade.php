@extends('layouts.app')

@section('title', 'Returns')

@section('page-title', 'Returns')

@section('content')

<style>
    /* ===== RETURNS PAGE ===== */

    .returns-page {
        width: 100%;
    }

    .returns-heading {
        margin-bottom: 28px;
    }

    .returns-heading h2 {
        margin: 0 0 6px;
        color: #5A4636;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .returns-heading p {
        margin: 0;
        color: #8A7768;
        font-size: 0.92rem;
    }

    /* ===== TABLE ===== */

    .returns-table-container {
        background-color: #F8F2E7;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #DCCDBB;
        box-shadow: 0 8px 25px rgba(90, 70, 54, 0.07);
    }

    .returns-table {
        width: 100%;
        border-collapse: collapse;
    }

    .returns-table thead {
        background-color: #6F8060;
        color: #F8F2E7;
    }

    .returns-table th {
        padding: 15px 16px;
        text-align: left;
        font-size: 0.88rem;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .returns-table td {
        padding: 15px 16px;
        border-bottom: 1px solid #E8DED2;
        font-size: 0.94rem;
    }

    .returns-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .returns-table tbody tr:hover {
        background-color: #F5E8E9;
    }

    /* ===== TEXT ===== */

    .borrowing-id {
        color: #6F8060;
        font-weight: 700;
    }

    .member-name,
    .book-title {
        color: #593C33;
        font-weight: 600;
    }

    .due-date {
        color: #8A7768;
    }

    /* ===== STATUS ===== */

    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status-borrowed {
        background-color: #DDE4D0;
        color: #5F7053;
    }

    .status-overdue {
        background-color: #E8C1C8;
        color: #8F5967;
    }

    /* ===== RETURN BUTTON ===== */

    .return-button {
        padding: 7px 14px;
        border: none;
        border-radius: 8px;
        background-color: #D99AA8;
        color: #FFFDF8;
        font-size: 0.84rem;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .return-button:hover {
        background-color: #B87586;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(184, 117, 134, 0.15);
    }

    /* ===== EMPTY STATE ===== */

    .empty-returns {
        padding: 30px;
        text-align: center;
        color: #8A7768;
        background-color: #F8F2E7;
        border: 1px solid #DCCDBB;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(90, 70, 54, 0.06);
    }

    /* ===== SEARCH ===== */

    .returns-search {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .returns-search input {
        flex: 1;
        padding: 11px 14px;
        border: 1px solid #DCCDBB;
        border-radius: 8px;
        background-color: #F8F2E7;
        color: #4A3A2E;
        font-size: 0.9rem;
        outline: none;
    }

    .returns-search input:focus {
        border-color: #B87586;
        box-shadow: 0 0 0 3px rgba(184, 117, 134, 0.12);
    }

    .returns-search button {
        padding: 11px 18px;
        border: none;
        border-radius: 8px;
        background-color: #6F8060;
        color: #FFFDF8;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .returns-search button:hover {
        background-color: #5F7053;
    }

    /* ===== RESPONSIVE ===== */

    @media (max-width: 800px) {

        .returns-table-container {
            overflow-x: auto;
        }

        .returns-table {
            min-width: 750px;
        }
    }
</style>

<div class="returns-page">

    <div class="returns-heading">

        <h2>Books to Return</h2>

        <p>Manage books that are currently borrowed and waiting to be returned.</p>

    </div>

    <form action="{{ route('returns.index') }}" method="GET" class="returns-search">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search borrowing ID, member, or book..."
        >

        <button type="submit">Search</button>
    </form>

    @if($borrowings->count())

        <div class="returns-table-container">

            <table class="returns-table">

                <thead>
                    <tr>
                        <th>Borrowing ID</th>
                        <th>Member</th>
                        <th>Book</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($borrowings as $borrowing)

                        <!-- For every active borrowing that the controller gave me, create one table row. -->

                        <tr>

                            <td class="borrowing-id">
                                {{ $borrowing->borrowing_id }}
                            </td>

                            <td class="member-name">
                                {{ $borrowing->member->member_name }}
                            </td>

                            <td class="book-title">
                                {{ $borrowing->book->title }}
                            </td>

                            <td class="due-date">
                                {{ $borrowing->due_date->format('d M Y') }}
                            </td>

                            <td>

                                <!-- Status: overdue or borrowed -->

                                @if(now()->gt($borrowing->due_date))

                                    <span class="status-badge status-overdue">
                                        Overdue
                                    </span>

                                @else

                                    <span class="status-badge status-borrowed">
                                        Borrowed
                                    </span>

                                @endif

                            </td>

                            <td>

                                <form
                                    action="{{ route('returns.update', $borrowing->id) }}"
                                    method="POST"
                                >

                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="return-button">
                                        Return
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="empty-returns">
            No books are currently waiting to be returned.
        </div>

    @endif


</div>

@endsection
