@extends('layouts.app')

@section('page-title', 'Reservation')

@section('content')

<style>
    /* ===== MAKE RESERVATION PAGE ===== */

    .reservation-page {
        width: 100%;
        max-width: 700px;
        margin: 0 auto;
    }

    .reservation-page h1 {
        margin: 0 0 6px;
        color: #5A4636;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .reservation-page > p {
        margin: 0 0 28px;
        color: #8A7768;
        font-size: 0.92rem;
    }

    /* ===== FORM ===== */

    .reservation-form {
        background-color: #F8F2E7;
        border: 1px solid #DCCDBB;
        border-radius: 16px;
        padding: 28px 30px;
        box-shadow: 0 8px 25px rgba(90, 70, 54, 0.08);
    }

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

    .form-control {
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

    .form-control:focus {
        border-color: #B87586;
        box-shadow: 0 0 0 3px rgba(184, 117, 134, 0.12);
    }

    /* ===== SEARCHABLE SELECT ===== */

    .search-select {
        position: relative;
    }

    .search-input {
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

    .search-input:focus {
        border-color: #B87586;
        box-shadow: 0 0 0 3px rgba(184, 117, 134, 0.12);
    }

    .search-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 5px);
        left: 0;
        width: 100%;
        max-height: 190px;
        overflow-y: auto;
        background-color: #FFFDF8;
        border: 1px solid #D2C1AE;
        border-radius: 9px;
        box-shadow: 0 6px 18px rgba(90, 70, 54, 0.12);
        z-index: 100;
    }

    .search-dropdown.show {
        display: block;
    }

    .search-option {
        padding: 10px 13px;
        color: #4A3A2E;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background-color 0.15s ease;
    }

    .search-option:hover {
        background-color: #F1E6D8;
    }

    .no-results {
        padding: 10px 13px;
        color: #8A7768;
        font-size: 0.88rem;
    }

    /* ===== ERROR MESSAGE ===== */

    .error-message {
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 9px;
        background-color: #F5E1E4;
        color: #8F5967;
        border: 1px solid #E3C0C7;
        font-size: 0.9rem;
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

    .reserve-button {
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

    .reserve-button:hover {
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

    @media (max-width: 650px) {

        .reservation-page {
            max-width: 100%;
        }

        .reservation-form {
            padding: 22px;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .reserve-button,
        .cancel-button {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="reservation-page">
    
    <h1>Make a Reservation</h1>

    <p>Reserve an unavailable book for a library member.</p>

    @if(session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    <div class="reservation-form">

        <form action="{{ route('reservations.store') }}" method="POST">

            @csrf

            {{-- ===== MEMBER ===== --}}

            <div class="form-group">

                <label for="member_search">
                    Member
                </label>

                <div class="search-select">

                    <input
                        type="text"
                        id="member_search"
                        class="search-input"
                        placeholder="Type member ID or name..."
                        autocomplete="off"
                    >

                    <input
                        type="hidden"
                        name="member_id"
                        id="member_id"
                        required
                    >

                    <div class="search-dropdown" id="member_dropdown">

                        @foreach($members as $member)

                            <div
                                class="search-option member-option"
                                data-value="{{ $member->member_id }}"
                                data-search="{{ strtolower($member->member_id . ' ' . $member->member_name) }}"
                            >
                                {{ $member->member_id }} - {{ $member->member_name }}
                            </div>

                        @endforeach

                    </div>

                </div>

            </div>


            {{-- ===== BOOK ===== --}}

            <div class="form-group">

                <label for="book_search">
                    Book
                </label>

                <div class="search-select">

                    <input
                        type="text"
                        id="book_search"
                        class="search-input"
                        placeholder="Type book ID or title..."
                        autocomplete="off"
                    >

                    <input
                        type="hidden"
                        name="book_id"
                        id="book_id"
                        required
                    >

                    <div class="search-dropdown" id="book_dropdown">

                        @forelse($books as $book)

                            <div
                                class="search-option book-option"
                                data-value="{{ $book->book_id }}"
                                data-search="{{ strtolower($book->book_id . ' ' . $book->title) }}"
                            >
                                {{ $book->book_id }} - {{ $book->title }}
                            </div>

                        @empty

                            <div class="no-results">
                                No books are currently available for reservation.
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>


            <hr class="form-divider">


            {{-- ===== BUTTONS ===== --}}

            <div class="form-actions">

                <a
                    href="{{ route('reservations.index') }}"
                    class="cancel-button"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="reserve-button"
                >
                    Reserve Book
                </button>

            </div>

        </form>

    </div>


</div>

<script>

    function setupSearchSelect(searchInputId, hiddenInputId, dropdownId, optionClass)
    {
        const searchInput = document.getElementById(searchInputId);
        const hiddenInput = document.getElementById(hiddenInputId);
        const dropdown = document.getElementById(dropdownId);
        const options = dropdown.querySelectorAll('.' + optionClass);

        searchInput.addEventListener('focus', function () {
            dropdown.classList.add('show');
        });

        searchInput.addEventListener('input', function () {

            const searchValue = this.value.toLowerCase().trim();

            let found = false;

            options.forEach(function (option) {

                const searchText = option.dataset.search;

                if (searchText.includes(searchValue)) {

                    option.style.display = 'block';
                    found = true;

                } else {

                    option.style.display = 'none';

                }

            });

            dropdown.classList.add('show');

            if (!found && options.length > 0) {
                dropdown.innerHTML =
                    '<div class="no-results">No matching results found.</div>';
            }
        });

        options.forEach(function (option) {

            option.addEventListener('click', function () {

                searchInput.value = this.textContent.trim();

                hiddenInput.value = this.dataset.value;

                dropdown.classList.remove('show');

            });

        });

        document.addEventListener('click', function (event) {

            if (!searchInput.parentElement.contains(event.target)) {

                dropdown.classList.remove('show');

            } //ask Did they click outside this search component? //if yes the drop down disappear

        });
    }


    setupSearchSelect(
        'member_search',
        'member_id',
        'member_dropdown',
        'member-option'
    );


    setupSearchSelect(
        'book_search',
        'book_id',
        'book_dropdown',
        'book-option'
    );

</script>

@endsection
