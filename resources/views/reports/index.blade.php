@extends('layouts.app')

@section('title', 'Reports')

@section('page-title', 'Reports')

@section('content')

<style>
    .reports-header {
        margin-bottom: 25px;
    }

    .reports-header h2 {
        margin-bottom: 5px;
    }

    .reports-header p {
        color: #666;
    }

    .report-section {
        background: #F8F2E7;
        border-radius: 12px;
        padding: 22px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .report-section h3 {
        margin-bottom: 5px;
    }

    .report-description {
        color: #777;
        margin-bottom: 20px;
        
    }

    /* Simple Bar Chart */
    .chart {
        display: flex;
        align-items: flex-end;
        gap: 15px;
        height: 220px;
        padding: 20px 10px 0;
        border-bottom: 1px solid #ccc;
    }

    .chart-column {
        flex: 1;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: center;
    }

    .chart-bar {
        width: 60%;
        min-height: 3px;
        background: #659080;
        border-radius: 6px 6px 0 0;
    }

    .chart-number {
        font-size: 12px;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .chart-label {
        margin-top: 8px;
        font-size: 13px;
    }

    /* Two-column reports */
    .report-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    /* Tables */
    .report-table {
        width: 100%;
        border-collapse: collapse;
    }

    .report-table th,
    .report-table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    .report-table th {
        background: #D8C8B7;
    }

    .rank {
        font-weight: bold;
        width: 50px;
    }

    /* Fine summary */
    .fine-summary {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .fine-box {
        background: #D8C8B7;
        padding: 18px;
        border-radius: 10px;
        text-align: center;
    }

    .fine-box h4 {
        margin-bottom: 8px;
    }

    .fine-box strong {
        font-size: 22px;
    }

    @media (max-width: 800px) {
        .report-grid,
        .fine-summary {
            grid-template-columns: 1fr;
        }

        .chart {
            gap: 5px;
        }

        .chart-bar {
            width: 80%;
        }
    }

</style>


<div class="reports-header">
    <h2>Library Reports</h2>
    <p>
        Library activity and performance analysis for {{ $currentYear }}.
    </p>
</div>


{{-- 1. BORROWING TRENDS --}}
<div class="report-section">

    <h3>📖 Borrowing Trends</h3>

    <p class="report-description">
        Monthly borrowing activity for {{ $currentYear }}.
    </p>

    @php
        $maxBorrowings = max(
            1,
            collect($borrowingTrends)->max('total')
        );
    @endphp

    <div class="chart">

        @foreach ($borrowingTrends as $item)

            <div class="chart-column">

                <div class="chart-number">
                    {{ $item['total'] }}
                </div>

                <div
                    class="chart-bar"
                    style="height: {{ ($item['total'] / $maxBorrowings) * 100 }}%;"
                ></div>

                <div class="chart-label">
                    {{ $item['month'] }}
                </div>

            </div>

        @endforeach

    </div>

</div>


{{-- 2 + 3 --}}
<div class="report-grid">

    {{-- MOST BORROWED BOOKS --}}
    <div class="report-section">

        <h3>📚 Most Borrowed Books</h3>

        <p class="report-description">
            Top 5 most borrowed books in {{ $currentYear }}.
        </p>

        <table class="report-table">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Book</th>
                    <th>Borrowed</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($mostBorrowedBooks as $index => $item)

                    <tr>
                        <td class="rank">
                            {{ $index + 1 }}
                        </td>

                        <td>
                            {{ $item->book->title ?? 'Unknown Book' }}
                        </td>

                        <td>
                            {{ $item->total }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="3">
                            No borrowing data available.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- MOST ACTIVE MEMBERS --}}
    <div class="report-section">

        <h3>👥 Most Active Members</h3>

        <p class="report-description">
            Top 5 members by borrowing activity.
        </p>

        <table class="report-table">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Member</th>
                    <th>Borrowed</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($mostActiveMembers as $index => $item)

                    <tr>
                        <td class="rank">
                            {{ $index + 1 }}
                        </td>

                        <td>
                            {{ $item->member->member_name ?? 'Unknown Member' }}
                        </td>

                        <td>
                            {{ $item->total }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="3" >
                            No borrowing data available.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- 4. POPULAR CATEGORIES --}}
<div class="report-section">

    <h3>🏷️ Popular Categories</h3>

    <p class="report-description">
        Categories with the highest number of borrowings.
    </p>

    <table class="report-table">

        <thead>
            <tr>
                <th>#</th>
                <th>Category</th>
                <th>Total Borrowings</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($popularCategories as $index => $category)

                <tr>
                    <td class="rank">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $category->name }}
                    </td>

                    <td>
                        {{ $category->total }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="3">
                        No category data available.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>


{{-- 5. OVERDUE ANALYSIS --}}
<div class="report-section">

    <h3>⚠️ Overdue Analysis</h3>

    <p class="report-description">
        Monthly overdue activity for {{ $currentYear }}.
    </p>

    @php
        $maxOverdues = max(
            1,
            collect($overdueAnalysis)->max('total')
        );
    @endphp

    <div class="chart">

        @foreach ($overdueAnalysis as $item)

            <div class="chart-column">

                <div class="chart-number">
                    {{ $item['total'] }}
                </div>

                <div
                    class="chart-bar"
                    style="height: {{ ($item['total'] / $maxOverdues) * 100 }}%;"
                ></div>

                <div class="chart-label">
                    {{ $item['month'] }}
                </div>

            </div>

        @endforeach

    </div>

</div>


{{-- 6. FINE ANALYSIS --}}
<div class="report-section">

    <h3>💰 Fine Analysis</h3>

    <p class="report-description">
        Fine activity and payment status for {{ $currentYear }}.
    </p>


    <div class="fine-summary">

        <div class="fine-box">
            <h4>Total Fines</h4>
            <strong>${{ number_format($totalFines, 2) }}</strong>
        </div>

        <div class="fine-box">
            <h4>Paid</h4>
            <strong>${{ number_format($paidFines, 2) }}</strong>
        </div>

        <div class="fine-box">
            <h4>Unpaid</h4>
            <strong>${{ number_format($unpaidFines, 2) }}</strong>
        </div>

    </div>


    @php
        $maxFines = max(
            1,
            collect($fineAnalysis)->max('total')
        );
    @endphp

    <div class="chart">

        @foreach ($fineAnalysis as $item)

            <div class="chart-column">

                <div class="chart-number">
                    ${{ number_format($item['total'], 2) }}
                </div>

                <div
                    class="chart-bar"
                    style="height: {{ ($item['total'] / $maxFines) * 100 }}%;"
                ></div>

                <div class="chart-label">
                    {{ $item['month'] }}
                </div>

            </div>

        @endforeach

    </div>

</div>


{{-- 7. COLLECTION SUMMARY --}}
<div class="report-section">

    <h3>📦 Collection Summary</h3>

    <p class="report-description">
        Overview of the library collection by category.
    </p>

    <table class="report-table">

        <thead>
            <tr>
                <th>Category</th>
                <th>Titles</th>
                <th>Total Copies</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($collectionSummary as $category)

                <tr>
                    <td>
                        {{ $category->name }}
                    </td>

                    <td>
                        {{ $category->books_count }}
                    </td>

                    <td>
                        {{ $category->total_copies }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="3">
                        No collection data available.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>


{{-- 8. LOW-CIRCULATION BOOKS --}}
<div class="report-section">

    <h3>📕 Low-Circulation Books</h3>

    <p class="report-description">
        Books with the fewest borrowings in {{ $currentYear }}.
    </p>

    <table class="report-table">

        <thead>
            <tr>
                <th>Book</th>
                <th>Borrowed</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($lowCirculationBooks as $book)

                <tr>
                    <td>
                        {{ $book->title }}
                    </td>

                    <td>
                        {{ $book->borrowings_count }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="2">
                        No book data available.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection