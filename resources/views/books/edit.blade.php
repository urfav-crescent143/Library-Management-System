@extends('layouts.app')

@section('page-title', 'Books')

@section('content')

<style>
    /* ===== EDIT BOOK PAGE ===== */

    .edit-book-page {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
    }

    .edit-book-page h1 {
        margin: 0 0 6px;
        color: #3F4438;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .edit-book-page > p {
        margin: 0 0 28px;
        color: #777A69;
        font-size: 0.92rem;
    }

    /* Form card */

    .book-form {
        background-color: #F8F2E7;
        border: 1px solid #E2D6C7;
        border-radius: 16px;
        padding: 28px 30px;
        box-shadow: 0 8px 25px rgba(63, 68, 56, 0.07);
    }

    /* Form groups */

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        color: #3F4438;
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* Inputs */

    .form-control,
    .form-group select {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #D8C8B7;
        border-radius: 9px;
        background-color: #FFFDF8;
        color: #3F4438;
        outline: none;
        font-size: 0.92rem;
        transition: 0.2s ease;
    }

    .form-control:focus,
    .form-group select:focus {
        border-color: #D99AA8;
        box-shadow: 0 0 0 3px rgba(217, 154, 168, 0.12);
    }

    /* Book ID */

    .book-id-input {
        color: #6F8060;
        font-weight: 700;
        background-color: #EDE7DA;
    }

    /* Copies */

    .copies-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    /* Divider */

    .form-divider {
        border: none;
        border-top: 1px solid #E8DED2;
        margin: 25px 0 20px;
    }

    /* Buttons */

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
    }

    .save-button {
        padding: 10px 20px;
        border: none;
        border-radius: 9px;
        background-color: #6F8060;
        color: #F8F2E7;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .save-button:hover {
        background-color: #5F7053;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(63, 68, 56, 0.12);
    }

    .cancel-button {
        display: inline-block;
        padding: 10px 20px;
        border: 1px solid #E2C5CA;
        border-radius: 9px;
        background-color: #E8C1C8;
        color: #7E5360;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        transition: 0.2s ease;
    }

    .cancel-button:hover {
        background-color: #D99AA8;
        color: #FFFDF8;
        transform: translateY(-1px);
    }

    /* Mobile */

    @media (max-width: 650px) {

        .edit-book-page {
            max-width: 100%;
        }

        .book-form {
            padding: 22px;
        }

        .copies-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .save-button,
        .cancel-button {
            width: 100%;
            text-align: center;
        }
    }
</style>


<div class="edit-book-page">

    <h1>Edit Book</h1>

    <p>Update the information for this book.</p>


    <div class="book-form">

        <form action="{{ route('books.update', $book) }}" method="POST">

            @csrf

            @method('PUT')


            <!-- BOOK ID -->

            <div class="form-group">

                <label for="book_id">
                    Book ID
                </label>

                <input
                    type="text"
                    id="book_id"
                    name="book_id"
                    class="form-control book-id-input"
                    value="{{ old('book_id', $book->book_id) }}"
                >

            </div>


            <!-- TITLE -->

            <div class="form-group">

                <label for="title">
                    Title
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    class="form-control"
                    value="{{ old('title', $book->title) }}"
                >

            </div>


            <!-- AUTHOR -->

            <div class="form-group">

                <label for="author_id">
                    Author
                </label>

                <select
                    id="author_id"
                    name="author_id"
                >

                    @foreach ($authors as $author)

                        <option
                            value="{{ $author->author_id }}"
                            {{ old('author_id', $book->author_id) == $author->author_id ? 'selected' : '' }}
                        >
                            {{ $author->author_name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <!-- CATEGORY -->

            <div class="form-group">

                <label for="category_id">
                    Category
                </label>

                <select
                    id="category_id"
                    name="category_id"
                >

                    @foreach ($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <!-- COPIES -->

            <div class="copies-row">

                <div class="form-group">

                    <label for="total_copies">
                        Total Copies
                    </label>

                    <input
                        type="number"
                        id="total_copies"
                        name="total_copies"
                        class="form-control"
                        min="1"
                        value="{{ old('total_copies', $book->total_copies) }}"
                    >

                </div>


                <div class="form-group">

                    <label for="available_copies">
                        Available Copies
                    </label>

                    <input
                        type="number"
                        id="available_copies"
                        name="available_copies"
                        class="form-control"
                        min="0"
                        value="{{ old('available_copies', $book->available_copies) }}"
                    >

                </div>

            </div>


            <hr class="form-divider">


            <!-- BUTTONS -->

            <div class="form-actions">

                <a
                    href="{{ route('books.index') }}"
                    class="cancel-button"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="save-button"
                >
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
