@extends('layouts.app')

@section('title', 'Fines')

@section('page-title', 'Fines')

@section('content')

<style>
    /* ===== FINES PAGE ===== */

    .fines-page {
        width: 100%;
    }

    /* ---------- TABLE CONTAINER ---------- */

    .fines-table-container {
        background-color: #F8F2E7;
        border-radius: 16px;
        border: 1px solid #E2D6C7;
        box-shadow: 0 8px 25px rgba(63, 68, 56, 0.07);
        overflow: hidden;
    }


    /* ---------- TABLE ---------- */

    .fines-table {
        width: 100%;
        border-collapse: collapse;
    }

    .fines-table thead {
        background-color: #6F8060;
        color: #F8F2E7;
    }

    .fines-table th {
        padding: 15px 16px;
        text-align: left;
        font-size: 0.88rem;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .fines-table td {
        padding: 15px 16px;
        color: #3F4438;
        border-bottom: 1px solid #E8DED2;
        font-size: 0.94rem;
    }

    .fines-table tbody tr {
        transition: 0.2s ease;
    }

    .fines-table tbody tr:hover {
        background-color: #F5E8E9;
    }

    .fines-table tbody tr:last-child td {
        border-bottom: none;
    }


    /* ---------- FINE ID ---------- */

    .fine-id {
        color: #6F8060;
        font-weight: 700;
    }


    /* ---------- BORROWING ID ---------- */

    .borrowing-id {
        color: #B87586;
        font-weight: 600;
    }


    /* ---------- MEMBER ---------- */

    .member-name {
        font-weight: 600;
        color: #593C33;
    }


    /* ---------- OVERDUE DAYS ---------- */

    .overdue-days {
        color: #db4453;
        font-weight: 600;
    }


    /* ---------- AMOUNT ---------- */

    .fine-amount {
        color:#556f30;
        font-weight: 600;
    }


    /* ---------- STATUS ---------- */

    .status {
        display: inline-block;
        padding: 5px 11px;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 600;
    }

    .status-unpaid {
        background-color: #E8C1C8;
        color: #8F5967;
    }

    .status-paid {
        background-color: #DDE4D0;
        color: #5F7053;
    }


    /* ---------- PAID DATE ---------- */

    .paid-date {
        color: #777A69;
    }


    /* ---------- PAY BUTTON ---------- */

    .pay-button {
        padding: 7px 14px;
        border: none;
        border-radius: 8px;
        background-color: #D99AA8;
        color: #fffaf5;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .pay-button:hover {
        background-color: #B87586;
        transform: translateY(-1px);
    }


    /* ---------- EMPTY STATE ---------- */

    .empty-state {
        text-align: center;
        padding: 40px 20px !important;
        color: #777A69 !important;
    }
    /* ---------- SEARCH ---------- */

    .fines-search {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .fines-search input {
        flex: 1;
        padding: 11px 14px;
        border: 1px solid #E2D6C7;
        border-radius: 8px;
        background-color: #F8F2E7;
        color: #3F4438;
        font-size: 0.9rem;
        outline: none;
    }

    .fines-search input:focus {
        border-color: #B87586;
        box-shadow: 0 0 0 3px rgba(184, 117, 134, 0.12);
    }

    .fines-search button {
        padding: 11px 18px;
        border: none;
        border-radius: 8px;
        background-color: #6F8060;
        color: #F8F2E7;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .fines-search button:hover {
        background-color: #5F7053;
    }

</style>

<div class="fines-page">

    <form action="{{ route('fines.index') }}" method="GET" class="fines-search" id="fineSearchForm" >

        <input 
            type="text" 
            name="search" 
            id="fineSearch"
            value="{{ request('search') }}" 
            placeholder="Search fine ID, borrowing ID, member, or book..."
            autocomplete="off"
        >

        <button type="submit">
            Search
        </button>

    </form>


    @if($fines->count())

        <div class="fines-table-container">

            <table class="fines-table">

                <thead>
                    <tr>
                        <th>Fine ID</th>
                        <th>Borrowing ID</th>
                        <th>Member</th>
                        <th>Overdue Days</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Paid At</th>
                        <th>Action</th>
                    </tr>
                </thead>


                <tbody>

                    @foreach($fines as $fine)

                        <tr>

                            <td>
                                <span class="fine-id">
                                    {{ $fine->id }}
                                </span>
                            </td>


                            <td>
                                <span class="borrowing-id">
                                    {{ $fine->borrowing->borrowing_id }}
                                </span>
                            </td>


                            <td>
                                <span class="member-name">
                                    {{ $fine->borrowing->member->member_name }}
                                </span>
                            </td>


                            <td>
                                <span class="overdue-days">
                                    {{ $fine->overdue_days }} days
                                </span>
                            </td>


                            <td>
                                <span class="fine-amount">
                                    ${{ number_format($fine->amount, 2) }}
                                </span>
                            </td>


                            <td>

                                @if($fine->status === 'Unpaid')

                                    <span class="status status-unpaid">
                                        Unpaid
                                    </span>

                                @else

                                    <span class="status status-paid">
                                        Paid
                                    </span>

                                @endif

                            </td>


                            <td>
                                <span class="paid-date">

                                    @if($fine->paid_at)
                                        {{ $fine->paid_at->format('d M Y') }}
                                    @else
                                        —
                                    @endif

                                </span>
                            </td>


                            <td>

                                @if($fine->status === 'Unpaid')

                                    <form
                                        action="{{ route('fines.pay', $fine->id) }}"
                                        method="POST"
                                    >

                                        @csrf
                                        @method('PUT')

                                        <button
                                            type="submit"
                                            class="pay-button"
                                        >
                                            Pay
                                        </button>

                                    </form>

                                @else

                                    —

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="fines-table-container">

            <p class="empty-state">
                No fines recorded.
            </p>

        </div>

    @endif

</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const fineSearch = document.getElementById('fineSearch');
    const fineSearchForm = document.getElementById('fineSearchForm');

    let timer;

    fineSearch.addEventListener('input', function () {

        clearTimeout(timer);

        timer = setTimeout(function () {
            fineSearchForm.submit();
        }, 300);

    });

});
</script>

@endsection
