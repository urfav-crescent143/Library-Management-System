@extends('layouts.app')

@section('page-title', 'Reservations')

@section('content')

<style>
    .reservation-page{
        width: 100%;
    }
        /* ===== RESERVATIONS PAGE ===== */

    .reservations-toolbar {
        display:flex;
        flex-direction:column;
        align-items:flex-start;
        margin-bottom:28px;
        gap:16px;
    }

    .reservations-heading h1 {
        margin:0 0 6px;
        color:#5A4636;
        font-size:1.5rem;
        font-weight:700;
    }

    .reservations-heading p {
        margin:0;
        color:#8A7768;
        font-size:.92rem;
    }

    .reservations-actions {
        display:flex;
        align-items:center;
        gap:10px;
        width:100%;
    }

    .reservation-search {
        display:flex;
        align-items:center;
        gap:8px;
    }

    .reservation-search input {
        width:320px;
        padding:10px 13px;
        border:1px solid #D2C1AE;
        border-radius:9px;
        background:#FFFDF8;
        color:#4A3A2E;
        outline:none;
        font-family:inherit;
        font-size:.9rem;
    }

    .reservation-search input:focus {
        border-color:#B87586;
        box-shadow:0 0 0 3px rgba(184,117,134,.12);
    }

    .reservation-search button {
        padding:10px 16px;
        border:none;
        border-radius:9px;
        background:#D99AA8;
        color:#FFFDF8;
        font-weight:600;
        cursor:pointer;
    }

    .clear-search {
        color:#B87586;
        text-decoration:none;
        font-size:.85rem;
        font-weight:600;
    }

    .reserve-btn {
        display:inline-block;
        margin-left: auto;
        padding:10px 18px;
        background:#6F8060;
        color:#F8F2E7;
        text-decoration:none;
        border-radius:9px;
        font-weight:600;
        font-size:.9rem;
        transition:.25s ease;
    }

    .reserve-btn:hover {
        background:#5F7053;
        transform:translateY(-1px);
    }

    /* ===== ALERT MESSAGES ===== */

    .reservation-message {
        padding: 12px 15px;
        margin-bottom: 18px;
        border-radius: 9px;
        font-size: 0.9rem;
    }

    .success-message {
        background-color: #DDE4D0;
        color: #5F7053;
        border: 1px solid #C8D2B8;
    }

    .error-message {
        background-color: #F5E1E4;
        color: #8F5967;
        border: 1px solid #E3C0C7;
    }

    /* ===== TABLE ===== */

    .reservations-table-container {
        background-color: #F8F2E7;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #DCCDBB;
        box-shadow: 0 8px 25px rgba(90, 70, 54, 0.07);
    }

    .reservations-table {
        width: 100%;
        border-collapse: collapse;
    }

    .reservations-table thead {
        background-color: #6F8060;
        color: #F8F2E7;
    }

    .reservations-table th {
        padding: 15px 16px;
        text-align: left;
        font-size: 0.88rem;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .reservations-table td {
        padding: 15px 16px;
        border-bottom: 1px solid #E8DED2;
        font-size: 0.94rem;
    }

    .reservations-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .reservations-table tbody tr:hover {
        background-color: #F5E8E9;
    }

    .reservation-id {
        color: #6F8060;
        font-weight: 700;
    }

    .member-name {
        color: #5A4636;
        font-weight: 600;
    }
    .book-title{
        color:#526747;
        font-weight:600;
    }

    .date-text {
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

    .status-pending {
        background-color: #EDE7DA;
        color: #8A7768;
    }

    .status-ready {
        background-color: #DDE4D0;
        color: #5F7053;
    }

    .status-fulfilled {
        background-color: #E8C1C8;
        color: #7E5360;
    }

    .status-cancelled {
        background-color: #E6DED7;
        color: #76685E;
    }

    /* ===== FULFILL BUTTON ===== */

    .fulfill-btn {
        margin-left: 8px;
        padding: 6px 11px;
        border: none;
        border-radius: 7px;
        background-color: #D99AA8;
        color: #FFFDF8;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .fulfill-btn:hover {
        background-color: #B87586;
        transform: translateY(-1px);
    }

    .empty-message {
        text-align: center;
        padding: 30px !important;
        color: #8A7768 !important;
    }

    /* ===== RESPONSIVE ===== */

    @media (max-width: 1000px) {

        .reservations-toolbar {
            align-items: flex-start;
        }

        .reservation-search {
            margin-left: 0;
        }
    }

    @media (max-width: 800px) {

        .reservations-table-container {
            overflow-x: auto;
        }

        .reservations-table {
            min-width: 750px;
        }

        .reservations-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .reservation-search {
            width: 100%;
        }

        .reservation-search input {
            width: 100%;
        }

        .reserve-btn {
            width: fit-content;
        }
    }

    @media (max-width: 550px) {

        .reservation-search {
            flex-wrap: wrap;
        }

        .reservation-search input {
            width: 100%;
        }
    }
</style>

<div class="reservations-page">

    <div class="reservations-toolbar">

        <div class="reservations-heading">
            <h1>Reservations</h1>
            <p>Manage book reservations and fulfillment.</p>
        </div>

        <div class="reservations-actions">

            <form action="{{ route('reservations.index') }}" method="GET" class="reservation-search" id="reservationSearchForm">
                <input
                    type="text"
                    name="search"
                    id="reservationSearch"
                    value="{{ request('search') }}"
                    placeholder="Search reservation, member, book, or status..."
                    autocomplete="off"
                >

                <button type="submit">Search</button>

                @if(request('search'))
                    <a href="{{ route('reservations.index') }}" class="clear-search">
                        Clear
                    </a>
                @endif
            </form>

            <a href="{{ route('reservations.create') }}" class="reserve-btn">
                + Reserve Book
            </a>

        </div>

    </div>


</div>



    @if(session('success'))

        <div class="reservation-message success-message">
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="reservation-message error-message">
            {{ session('error') }}
        </div>

    @endif


    <div class="reservations-table-container">

        <table class="reservations-table">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Member</th>
                    <th>Book</th>
                    <th>Reserved At</th>
                    <th>Status</th>
                    <th>Fulfilled At</th>
                </tr>

            </thead>


            <tbody>

                @forelse($reservations as $reservation)

                    <tr>

                        <td class="reservation-id">
                            {{ $reservation->reservation_id }}
                        </td>

                        <td class="member-name">
                            {{ $reservation->member->member_name }}
                        </td>

                        <td class="book-title">
                            {{ $reservation->book->title }}
                        </td>

                        <td class="date-text">
                            {{ $reservation->reserved_at->format('d M Y, h:i A') }}
                        </td>

                        <td>

                            @if($reservation->status === 'Pending')

                                <span class="status-badge status-pending">
                                    Pending
                                </span>

                            @elseif($reservation->status === 'Ready')

                                <span class="status-badge status-ready">
                                    Ready
                                </span>

                                <form
                                    action="{{ route('reservations.fulfill', $reservation) }}"
                                    method="POST"
                                    style="display: inline;"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="fulfill-btn"
                                    >
                                        Fulfill
                                    </button>

                                </form>

                            @elseif($reservation->status === 'Fulfilled')

                                <span class="status-badge status-fulfilled">
                                    Fulfilled
                                </span>

                            @elseif($reservation->status === 'Cancelled')

                                <span class="status-badge status-cancelled">
                                    Cancelled
                                </span>

                            @endif

                        </td>

                        <td class="date-text">

                            {{ $reservation->fulfilled_at
                                ? $reservation->fulfilled_at->format('d M Y, h:i A')  
                                : '—' 
                            }} 

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="empty-message">
                            No reservations found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const reservationSearch = document.getElementById('reservationSearch');
    const reservationSearchForm = document.getElementById('reservationSearchForm');

    let timer;

    reservationSearch.addEventListener('input', function () {

        clearTimeout(timer);

        timer = setTimeout(function () {
            reservationSearchForm.submit();
        }, 300);

    });

});
</script>

@endsection
