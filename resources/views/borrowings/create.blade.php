@extends('layouts.app')

@section('page-title', 'Borrowings')

@section('content')

<style>
    /* ===== BORROW BOOK PAGE ===== */

    .borrow-page {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
    }

    .borrow-page h1 {
        margin: 0 0 6px;
        color: #5A4636;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .borrow-page > p {
        margin: 0 0 28px;
        color: #8A7768;
        font-size: 0.92rem;
    }

    /* ===== FORM CARD ===== */

    .borrow-form {
        background-color: #F8F2E7;
        border: 1px solid #DCCDBB;
        border-radius: 16px;
        padding: 28px 30px;
        box-shadow: 0 8px 25px rgba(90, 70, 54, 0.08);
    }

    /* ===== FORM GROUPS ===== */

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        color: #5A4636;
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* ===== SEARCHABLE FIELDS ===== */

    .searchable {
        position: relative;
        width: 100%;
    }

    .searchable input {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #D2C1AE;
        border-radius: 9px;
        background-color: #FFFDF8;
        color: #4A3A2E;
        outline: none;
        font-size: 0.92rem;
        box-sizing: border-box;
        transition: 0.2s ease;
    }

    .searchable input::placeholder {
        color: #9B8A7B;
    }

    .searchable input:focus {
        border-color: #B87586;
        box-shadow: 0 0 0 3px rgba(184, 117, 134, 0.12);
    }

    /* ===== DROPDOWN OPTIONS ===== */

    .options {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: #FFFDF8;
        border: 1px solid #D2C1AE;
        border-top: none;
        max-height: 180px;
        overflow-y: auto;
        z-index: 10;
        border-radius: 0 0 9px 9px;
        box-shadow: 0 7px 18px rgba(90, 70, 54, 0.12);
    }

    .option {
        padding: 10px 13px;
        color: #5A4636;
        cursor: pointer;
        font-size: 0.9rem;
        transition: 0.15s ease;
    }

    .option:hover {
        background-color: #F5E8E9;
        color: #7E5360;
    }

    select {
        display: none;
    }

    /* ===== DATES ===== */

    .date-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-top: 4px;
    }

    .date-field label {
        display: block;
        margin-bottom: 7px;
        color: #5A4636;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .date-field input {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #D2C1AE;
        border-radius: 9px;
        background-color: #FFFDF8;
        color: #4A3A2E;
        outline: none;
        font-size: 0.92rem;
        font-family: inherit;
        box-sizing: border-box;
        transition: 0.2s ease;
    }

    .date-field input:focus {
        border-color: #B87586;
        box-shadow: 0 0 0 3px rgba(184, 117, 134, 0.12);
    }

    /* ===== DIVIDER ===== */

    .form-divider {
        border: none;
        border-top: 1px solid #E2D6C7;
        margin: 25px 0 20px;
    }

    /* ===== BUTTONS ===== */

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
    }

    .borrow-button {
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

    .borrow-button:hover {
        background-color: #5F7053;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(63, 68, 56, 0.12);
    }

    .cancel-button {
        display: inline-block;
        padding: 10px 20px;
        border: 1px solid #D6B8A0;
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

    /* ===== MOBILE ===== */

    @media (max-width: 650px) {

        .borrow-page {
            max-width: 100%;
        }

        .borrow-form {
            padding: 22px;
        }

        .date-row {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .borrow-button,
        .cancel-button {
            width: 100%;
            text-align: center;
        }
    }
    .alert-error {
        background-color: #FBE9E7;
        color: #8F3E43;
        border: 1px solid #DDA5A5;
        border-left: 5px solid #B87586;
        border-radius: 8px;
        padding: 14px 18px;
        margin: 18px 0;
        display: flex;
        flex-direction: column;
        gap: 4px;
        font-size: 15px;
    }

    .error-title {
        font-weight: 700;
        font-size: 16px;
    }
</style>


<div class="borrow-page">

    <h1>Borrow a Book</h1>

    <p>Record a new book borrowing transaction.</p>

    <!-- //Notification if borrow failed -->
    
    @if (session('error'))
        <div class="alert-error">
            <span class="error-title">Borrowing Unsuccessful!</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif


    <div class="borrow-form">

        <form action="{{ route('borrowings.store') }}" method="POST">

            @csrf


            <!-- ================= MEMBER ================= -->

            <div class="form-group">

                <label for="member_search">
                    Member
                </label>

                <div class="searchable">

                    <input
                        type="text"
                        id="member_search"
                        placeholder="Search or select a member"
                        autocomplete="off"
                    >

                    <div class="options" id="member_options">

                        @foreach ($members as $member)

                            <div
                                class="option"
                                data-value="{{ $member->id }}"
                                data-name="{{ $member->member_name }}"
                            >
                                {{ $member->member_name }}
                            </div>

                        @endforeach

                    </div>

                </div>


                <!-- Hidden select still sends member_id to Laravel -->

                <select
                    name="member_id"
                    id="member_id"
                    required
                >

                    <option value="">
                        Select a member
                    </option>

                    @foreach ($members as $member)

                        <option value="{{ $member->id }}">
                            {{ $member->member_name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <!-- ================= BOOK ================= -->

            <div class="form-group">

                <label for="book_search">
                    Book
                </label>

                <div class="searchable">

                    <input
                        type="text"
                        id="book_search"
                        placeholder="Search or select a book"
                        autocomplete="off"
                    >

                    <div class="options" id="book_options">

                        @foreach ($books as $book)

                            <div
                                class="option"
                                data-value="{{ $book->id }}"
                                data-name="{{ $book->title }}"
                            >
                                {{ $book->title }} — {{ $book->available_copies }} available
                            </div>

                        @endforeach

                    </div>

                </div>


                <!-- Hidden select still sends book_id to Laravel -->

                <select
                    name="book_id"
                    id="book_id"
                    required
                >

                    <option value="">
                        Select a book
                    </option>

                    @foreach ($books as $book)

                        <option value="{{ $book->id }}">
                            {{ $book->title }} — {{ $book->available_copies }} available
                        </option>

                    @endforeach

                </select>

            </div>


            <!-- ================= DATES ================= -->

            <div class="date-row">

                <div class="date-field">

                    <label for="borrowed_at">
                        Borrowed Date
                    </label>

                    <input
                        type="date"
                        id="borrowed_at"
                        name="borrowed_at"
                        required
                    >

                </div>


                <div class="date-field">

                    <label for="due_date">
                        Due Date
                    </label>

                    <input
                        type="date"
                        id="due_date"
                        name="due_date"
                        required
                    >

                </div>

            </div>


            <hr class="form-divider">


            <!-- ================= BUTTON ================= -->

            <div class="form-actions">

                <a
                    href="{{ route('borrowings.index') }}"
                    class="cancel-button"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="borrow-button"
                >
                    Borrow Book
                </button>

            </div>

        </form>

    </div>


</div>


<script>

    // ================= MEMBER SEARCH =================

    const memberSearch = document.getElementById('member_search');
    const memberOptions = document.getElementById('member_options');
    const memberSelect = document.getElementById('member_id');

    memberSearch.addEventListener('focus', function () {
        memberOptions.style.display = 'block';
    });

    memberSearch.addEventListener('input', function () {

        const search = this.value.toLowerCase();

        const options = memberOptions.querySelectorAll('.option');

        options.forEach(option => {

            const name = option.dataset.name.toLowerCase();

            if (name.includes(search)) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }

        });

        memberOptions.style.display = 'block';
    });

    memberOptions.addEventListener('click', function (event) {

        if (event.target.classList.contains('option')) {

            memberSearch.value = event.target.dataset.name;

            memberSelect.value = event.target.dataset.value;

            memberOptions.style.display = 'none';
        }

    });


    // ================= BOOK SEARCH =================

    const bookSearch = document.getElementById('book_search');
    const bookOptions = document.getElementById('book_options');
    const bookSelect = document.getElementById('book_id');

    bookSearch.addEventListener('focus', function () {
        bookOptions.style.display = 'block';
    });

    bookSearch.addEventListener('input', function () {

        const search = this.value.toLowerCase();

        const options = bookOptions.querySelectorAll('.option');

        options.forEach(option => {

            const name = option.dataset.name.toLowerCase();

            if (name.includes(search)) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }

        });

        bookOptions.style.display = 'block';
    });

    bookOptions.addEventListener('click', function (event) {

        if (event.target.classList.contains('option')) {

            bookSearch.value = event.target.dataset.name;

            bookSelect.value = event.target.dataset.value;

            bookOptions.style.display = 'none';
        }

    });

    // ================= CLOSE DROPDOWNS WHEN CLICKING OUTSIDE =================

    document.addEventListener('click', function (event) {

        // Close member dropdown
        if (!memberSearch.parentElement.contains(event.target)) {
            memberOptions.style.display = 'none';
        }

        // Close book dropdown
        if (!bookSearch.parentElement.contains(event.target)) {
            bookOptions.style.display = 'none';
        }

    });

</script>

@endsection