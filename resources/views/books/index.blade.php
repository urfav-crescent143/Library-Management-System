@extends('layouts.app')

@section('page-title', 'Books')

@section('content')

<style>
    /* ===== BOOKS PAGE ===== */

    .books-page {
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

    .page-header h1 {
        margin: 0 0 5px;
        color: #3F4438;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .page-header p {
        margin: 0;
        color: #777A69;
        font-size: 0.92rem;
    }

    /* Add Book button */
    .btn {
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

    .btn:hover {
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

    /* Book ID */
    .book-id {
        color: #6F8060;
        font-weight: 700;
    }

    /* Book title */
    .book-title {
        font-weight: 600;
        color: #593c33;
    }

    /* Author name */
    .author-name {
        color: #3F4438;
        
    }

    /* Category name */
    .category-name{
        color: #cf767f ;
        font-weight:500;
    }

    /* Copies */
    .copies-info {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .copies-total,
    .copies-available {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        font-size: 0.85rem; /*The whole row's default font size*/
        white-space: nowrap;
    }

    .copies-total {
        color: #5A4636;
    }

    .copies-available {
        color: #526747;
    }

    .copies-total span,
    .copies-available span {
        font-size: 0.90rem;
        font-weight: 600;
    }/* individual*/




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
    
</style>

<div class="books-page">

    <div class="page-header">

        <form action="{{ route('books.index') }}" method="GET" class="search-form">
            <input
                type="text"
                name="search"
                placeholder="Search books..."
                value="{{ request('search') }}"
            >

            <button type="submit" class="btn">Search</button>
        </form>

        <a href="{{ route('books.create') }}" class="btn">
            + Add Book
        </a>

    </div>


    <div class="table-container">

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Copies</th>
                    <th>Actions</th>
                </tr>
            </thead>


            <tbody>

                @forelse ($books as $book)

                    <tr>

                        <td>
                            <span class="book-id">
                                {{ $book->book_id }}
                            </span>
                        </td>


                        <td>
                            <strong class="book-title">
                                {{ $book->title }}
                            </strong>
                        </td>


                        <td> 
                            <span class="author-name">
                                {{ $book->author->author_name ?? 'Unknown' }}
                            </span>
                            
                        </td>


                        <td>
                            <span class="category-name">
                                {{ $book->category->name ?? 'Unknown' }}
                            </span>
                        </td>

                        <td>
                            <div class="copies-info">
                                <div class="copies-total">
                                    <span>Total</span>
                                    <span>{{ $book->total_copies }}</span>
                                </div>

                                <div class="copies-available">
                                    <span>Available</span>
                                    <span>{{ $book->available_copies }}</span>
                                </div>
                            </div>
                        </td>
                       
    


                        <td>
                            <a
                                href="{{ route('books.edit', $book) }}"
                                class="edit-link"
                            >
                                Edit
                            </a>
                        </td>

                    </tr>


                @empty

                    <tr>
                        <td colspan="6" class="empty-state">
                            No books found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


</div>

@endsection
