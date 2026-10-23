@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<style>
    /* ===== DASHBOARD ===== */

    .dashboard-page {
        width: 100%;
    }

    /* ===== BANNER ===== */

    .dashboard-banner {
        position: relative;
        padding: 28px 30px;
        margin-bottom: 28px;
        background: linear-gradient(
            135deg,
            #F8E6E9,
            #F3EBDD,
            #DDE4D0
        );
        border: 1px solid #DCCDBB;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(90, 70, 54, 0.07);
        overflow: hidden;
    }

    .dashboard-banner::after {
        content: "✿";
        position: absolute;
        right: 30px;
        top: 15px;
        font-size: 4rem;
        color: rgba(184, 117, 134, 0.18);
        transform: rotate(12deg);
    }

    .dashboard-banner h2 {
        margin: 0 0 6px;
        color: #5F7053;
        font-size: 1.7rem;
        font-weight: 700;
    }

    .dashboard-banner p {
        margin: 0;
        color: #8A7768;
        font-size: 0.95rem;
    }

    /* ===== STATISTICS ===== */

    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
        margin-bottom: 30px;
    }

    .stat-card {
        background-color: #F8F2E7;
        border: 1px solid #DCCDBB;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 6px 20px rgba(90, 70, 54, 0.06);
        transition: 0.25s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(90, 70, 54, 0.1);
        border-color: #D99AA8;
    }

    .stat-card > span {
        display: block;
        margin-bottom: 12px;
        font-size: 1.5rem;
    }

    .stat-card h3 {
        margin: 0 0 8px;
        color: #5A4636;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .stat-card p {
        margin: 0 0 12px;
        color: #6F8060;
        font-size: 1.8rem;
        font-weight: 700;
    }

    .stat-card a {
        color: #B87586;
        text-decoration: none;
        font-size: 0.82rem;
        font-weight: 600;
        transition: 0.2s ease;
    }

    .stat-card a:hover {
        color: #7E5360;
    }

    /* ===== DASHBOARD SECTIONS ===== */

    .dashboard-section {
        margin-bottom: 30px;
    }

    .dashboard-section h2 {
        margin: 0 0 15px;
        color: #5A4636;
        font-size: 1.2rem;
        font-weight: 700;
    }

    /* ===== TABLE CONTAINER ===== */

    .dashboard-table-container {
        background-color: #F8F2E7;
        border: 1px solid #DCCDBB;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(90, 70, 54, 0.06);
    }

    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
    }

    .dashboard-table thead {
        background-color: #6F8060;
        color: #F8F2E7;
    }

    .dashboard-table th {
        padding: 14px 16px;
        text-align: left;
        font-size: 0.86rem;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .dashboard-table td {
        padding: 14px 16px;
        color: #4A3A2E;
        border-bottom: 1px solid #E8DED2;
        font-size: 0.92rem;
    }

    .dashboard-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .dashboard-table tbody tr:hover {
        background-color: #F5E8E9;
    }

    /* ===== OVERDUE STATUS ===== */

    .overdue-status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 8px;
        background-color: #E8C1C8;
        color: #8F5967;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .overview-number {
        color: #6F8060;
        font-size: 1.05rem;
        font-weight: 700;
    }

    /* ===== EMPTY STATE ===== */

    .dashboard-empty {
        padding: 25px;
        background-color: #F8F2E7;
        border: 1px solid #DCCDBB;
        border-radius: 16px;
        color: #8A7768;
        text-align: center;
        box-shadow: 0 8px 25px rgba(90, 70, 54, 0.06);
    }

    /* ===== RESPONSIVE ===== */

    @media (max-width: 1200px) {
        .dashboard-stats {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 800px) {
        .dashboard-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .dashboard-table-container {
            overflow-x: auto;
        }

        .dashboard-table {
            min-width: 650px;
        }
    }

    @media (max-width: 550px) {
        .dashboard-stats {
            grid-template-columns: 1fr;
        }

        .dashboard-banner {
            padding: 22px;
        }
    }
</style>

<div class="dashboard-page">

    <!-- Slogan -->

    <div class="dashboard-banner">

        <h2>Ravenclaw Library</h2>

        <p>Where every book has its place.</p>

    </div>


    <!-- Statistics -->

    <div class="dashboard-stats">

        <div class="stat-card">

            <span>📚</span>

            <h3>Total Books</h3>

            <p>{{ $totalBooks }}</p>

            <a href="{{ route('books.index') }}">
                See more →
            </a>

        </div>


        <div class="stat-card">

            <span>👥</span>

            <h3>Active Members</h3>

            <p>{{ $activeMembers }}</p>

            <a href="{{ route('members.index') }}">
                See more →
            </a>

        </div>


        <div class="stat-card">

            <span>📖</span>

            <h3>Borrowed Books</h3>

            <p>{{ $borrowedBooks }}</p>

            <a href="{{ route('borrowings.index') }}">
                See more →
            </a>

        </div>


        <div class="stat-card">

            <span>⚠️</span>

            <h3>Overdue Books</h3>

            <p>{{ $overdueBooks }}</p>

            <a href="{{ route('returns.index') }}">
                See more →
            </a>

        </div>


        <div class="stat-card">

            <span>💰</span>

            <h3>Unpaid Fines</h3>

            <p>${{ number_format($unpaidFines, 2) }}</p>

            <a href="{{ route('fines.index') }}">
                See more →
            </a>

        </div>

    </div>


    <!-- Urgent Overdue Books -->

    <section class="dashboard-section">

        <h2>Urgent Overdue Books</h2>

        @if($overdueBorrowings->count())

            <div class="dashboard-table-container">

                <table class="dashboard-table">

                    <thead>

                        <tr>
                            <th>Member</th>
                            <th>Book Title</th>
                            <th>Due Date</th>
                            <th>Status</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($overdueBorrowings as $borrowing)

                            <tr>

                                <td>
                                    {{ $borrowing->member->member_name }}
                                </td>

                                <td>
                                    {{ $borrowing->book->title }}
                                </td>

                                <td>
                                    {{ $borrowing->due_date->format('M d, Y') }}
                                </td>

                                <td>

                                    <span class="overdue-status">

                                        {{ $borrowing->due_date->startOfDay()->diffInDays(now()->startOfDay()) }}
                                        days late

                                    </span>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="dashboard-empty">
                No overdue books. 
            </div>

        @endif

    </section>


    <!-- Library Overview -->

    <section class="dashboard-section">

        <h2>Library Overview</h2>

        <div class="dashboard-table-container">

            <table class="dashboard-table">

                <thead>

                    <tr>
                        <th>Total Copies</th>
                        <th>Available Copies</th>
                        <th>Borrowed Copies</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td class="overview-number">
                            {{ $totalCopies }}
                        </td>

                        <td class="overview-number">
                            {{ $availableCopies }}
                        </td>

                        <td class="overview-number">
                            {{ $borrowedCopies }}
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </section>


</div>

@endsection
