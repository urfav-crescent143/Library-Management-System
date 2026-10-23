@extends('layouts.app')

@section('page-title', 'Authors')

@section('content')

<style>
    /* ===== AUTHORS PAGE ===== */

    .authors-page {
        width: 100%;
    }

    /* Page header */
    .page-header {
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

    /* Add Author */
    .add-author-btn {
        display: inline-block;
        padding: 11px 20px;
        background-color: #6F8060;
        color: #F8F2E7;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        transition: 0.25s ease;
    }

    .add-author-btn:hover {
        background-color: #5F7053;
        transform: translateY(-1px);
    }

    /* Table container */
    .table-container {
        background-color: #F8F2E7;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #E2D6C7;
        box-shadow: 0 8px 25px rgba(63, 68, 56, 0.07);
    }

    /* Table */
    .table-container table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-container thead {
        background-color: #6F8060;
        color: #F8F2E7;
    }

    .table-container th {
        padding: 15px 16px;
        text-align: left;
        font-size: 0.88rem;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .table-container td {
        padding: 15px 16px;
        color: #3F4438;
        border-bottom: 1px solid #E8DED2;
        font-size: 0.94rem;
    }

    .table-container tbody tr {
        transition: 0.2s ease;
    }

    .table-container tbody tr:hover {
        background-color: #F5E8E9;
    }

    .table-container tbody tr:last-child td {
        border-bottom: none;
    }

    /* Author ID */
    .author-id {
        color: #6F8060;
        font-weight: 700;
    }

    /* Author name */
    .author-name {
        color: #452815;
        font-weight: 600;
    }

    /* Total books */
    .book-count {
        display: inline-block;
        min-width: 32px;
        padding: 5px 9px;
        text-align: center;
        align-items: center;
        border-radius: 8px;
        background-color: #DDE4D0;
        color: #5F7053;
        font-weight: 600;
        font-size: 0.85rem;
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

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 35px 20px !important;
        color: #777A69 !important;
    }
</style>

<div class="authors-page">

<div class="page-header">

    <form
        action="{{ route('authors.index') }}"
        method="GET"
        class="search-form"
    >

        <input
            type="text"
            name="search"
            placeholder="Search authors..."
            value="{{ request('search') }}"
        >

        <button type="submit">
            Search
        </button>

    </form>


    <a
        href="{{ route('authors.create') }}"
        class="add-author-btn"
    >
        + Add Author
    </a>

</div>


<div class="table-container">

    <table>

        <thead>
            <tr>
                <th>Author ID</th>
                <th>Author Name</th>
                <th>Nationality</th>
                <th>Total Books</th>
                <th>Actions</th>
            </tr>
        </thead>


        <tbody>

            @forelse ($authors as $author)

                <tr>

                    <td>
                        <span class="author-id">
                            {{ $author->author_id }}
                        </span>
                    </td>


                    <td>
                        <strong class="author-name">
                            {{ $author->author_name }}
                        </strong>
                    </td>


                    <td>
                        {{ $author->nationality ?? '—' }}
                    </td>


                    <td>
                        <span class="book-count">
                            {{ $author->books_count }}
                        </span>
                    </td>


                    <td>
                        <a
                            href="{{ route('authors.edit', $author) }}"
                            class="edit-link"
                        >
                            Edit
                        </a>
                    </td>

                </tr>


            @empty

                <tr>
                    <td colspan="5" class="empty-state">
                        No authors found.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>


</div>

@endsection
