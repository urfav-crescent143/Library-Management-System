@extends('layouts.app')

@section('page-title', 'Books')

@section('content')
    <style>
    /* ===== ADD BOOK PAGE ===== */

    .add-book-page {
        width: 100%;
        max-width: 900px;
        margin: 0;
    }

    .add-book-page h1 {
        margin: 0 0 6px;
        color: #3F4438;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .add-book-page > p {
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

    /* Normal inputs */
    .form-control {
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

    .form-control::placeholder {
        color: #999889;
    }

    .form-control:focus {
        border-color: #D99AA8;
        box-shadow: 0 0 0 3px rgba(217, 154, 168, 0.12);
    }

    /* Searchable fields */
    .searchable {
        position: relative;
        width: 100%;
    }

    .searchable input {
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

    .searchable input::placeholder {
        color: #999889;
    }

    .searchable input:focus {
        border-color: #D99AA8;
        box-shadow: 0 0 0 3px rgba(217, 154, 168, 0.12);
    }

    /* Dropdown options */
    .options {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: #FFFDF8;
        border: 1px solid #D8C8B7;
        border-top: none;
        max-height: 180px;
        overflow-y: auto;
        z-index: 20;
        border-radius: 0 0 9px 9px;
        box-shadow: 0 7px 18px rgba(63, 68, 56, 0.10);
    }

    .option {
        padding: 10px 13px;
        color: #3F4438;
        cursor: pointer;
        font-size: 0.9rem;
        transition: 0.15s ease;
    }

    .option:hover {
        background-color: #F5E8E9;
        color: #7E5360;
    }

    /* Hide original selects */
    .hidden-select {
        display: none;
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

    .add-button {
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

    .add-button:hover {
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

        .add-button,
        .cancel-button {
            width: 100%;
            text-align: center;
        }
    }
</style>
<body>
<div class="add-book-page">

    <h1>Add Book</h1>

    <p>Add a new book to your library collection.</p>


    <div class="book-form">

        <form action="{{ route('books.store') }}" method="POST">

            @csrf


            <!-- ================= TITLE ================= -->

            <div class="form-group">

                <label for="title">
                    Title
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    class="form-control"
                    placeholder="Enter book title"
                >

            </div>


            <!-- ================= AUTHOR ================= -->

            <div class="form-group">

                <label for="author_search">
                    Author
                </label>

                <div class="searchable">

                    <input
                        type="text"
                        id="author_search"
                        placeholder="Search or select an author"
                        autocomplete="off"
                    >

                    <div class="options" id="author_options">

                        @foreach ($authors as $author)

                            <div
                                class="option"
                                data-value="{{ $author->author_id }}"
                                data-name="{{ $author->author_name }}"
                            >
                                {{ $author->author_name }}
                            </div>

                        @endforeach

                    </div>

                </div>


                <!-- Hidden select sends author_id to Laravel -->

                <select
                    name="author_id"
                    id="author_id"
                    class="hidden-select"
                    required
                >

                    <option value="">
                        Select an author
                    </option>

                    @foreach ($authors as $author)

                        <option value="{{ $author->author_id }}">
                            {{ $author->author_name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <!-- ================= CATEGORY ================= -->

            <div class="form-group">

                <label for="category_search">
                    Category
                </label>

                <div class="searchable">

                    <input
                        type="text"
                        id="category_search"
                        placeholder="Search or select a category"
                        autocomplete="off"
                    >

                    <div class="options" id="category_options">

                        @foreach ($categories as $category)

                            <div
                                class="option"
                                data-value="{{ $category->id }}"
                                data-name="{{ $category->name }}"
                            >
                                {{ $category->name }}
                            </div>

                        @endforeach

                    </div>

                </div>


                <!-- Hidden select sends category_id to Laravel -->

                <select
                    name="category_id"
                    id="category_id"
                    class="hidden-select"
                    required
                >

                    <option value="">
                        Select a category
                    </option>

                    @foreach ($categories as $category)

                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <!-- ================= COPIES ================= -->

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
                        placeholder="e.g. 5"
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
                        placeholder="e.g. 5"
                    >

                </div>

            </div>


            <hr class="form-divider">


            <!-- ================= BUTTONS ================= -->

            <div class="form-actions">

                <a
                    href="{{ route('books.index') }}"
                    class="cancel-button"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="add-button"
                >
                    Add Book
                </button>

            </div>

        </form>

    </div>

</div>


<script>

    // ================= AUTHOR SEARCH =================

    const authorSearch = document.getElementById('author_search');
    const authorOptions = document.getElementById('author_options');
    const authorSelect = document.getElementById('author_id');

    authorSearch.addEventListener('focus', function () {
        authorOptions.style.display = 'block';
    });

    authorSearch.addEventListener('input', function () {

        const search = this.value.toLowerCase();

        const options = authorOptions.querySelectorAll('.option');

        options.forEach(option => {

            const name = option.dataset.name.toLowerCase();

            if (name.includes(search)) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }

        });

        authorOptions.style.display = 'block';
    });

    authorOptions.addEventListener('click', function (event) {

        if (event.target.classList.contains('option')) {

            authorSearch.value = event.target.dataset.name;

            authorSelect.value = event.target.dataset.value;

            authorOptions.style.display = 'none';

        }

    });


    // ================= CATEGORY SEARCH =================

    const categorySearch = document.getElementById('category_search');
    const categoryOptions = document.getElementById('category_options');
    const categorySelect = document.getElementById('category_id');

    categorySearch.addEventListener('focus', function () {
        categoryOptions.style.display = 'block';
    });

    categorySearch.addEventListener('input', function () {

        const search = this.value.toLowerCase();

        const options = categoryOptions.querySelectorAll('.option');

        options.forEach(option => {

            const name = option.dataset.name.toLowerCase();

            if (name.includes(search)) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }

        });

        categoryOptions.style.display = 'block';
    });

    categoryOptions.addEventListener('click', function (event) {

        if (event.target.classList.contains('option')) {

            categorySearch.value = event.target.dataset.name;

            categorySelect.value = event.target.dataset.value;

            categoryOptions.style.display = 'none';

        }

    });


    // ================= CLOSE DROPDOWNS WHEN CLICKING OUTSIDE =================

    document.addEventListener('click', function (event) {

        // Author
        if (!authorSearch.parentElement.contains(event.target)) {
            authorOptions.style.display = 'none';
        }

        // Category
        if (!categorySearch.parentElement.contains(event.target)) {
            categoryOptions.style.display = 'none';
        }

    });

</script>
@endsection