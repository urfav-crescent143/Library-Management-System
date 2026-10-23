@extends('layouts.app')

@section('page-title', 'Authors')

@section('content')

<style>
    /* ===== EDIT AUTHOR PAGE ===== */

    .edit-author-page {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
    }

    .edit-author-page h1 {
        margin: 0 0 6px;
        color: #3F4438;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .edit-author-page > p {
        margin: 0 0 28px;
        color: #777A69;
        font-size: 0.92rem;
    }

    /* Form card */

    .author-form {
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

    .form-control {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #D8C8B7;
        border-radius: 9px;
        background-color: #FFFDF8;
        color: #3F4438;
        outline: none;
        font-size: 0.92rem;
        font-family: inherit;
        box-sizing: border-box;
        transition: 0.2s ease;
    }

    .form-control::placeholder {
        color: #999889;
    }

    .form-control:focus {
        border-color: #D99AA8;
        box-shadow: 0 0 0 3px rgba(217, 154, 168, 0.12);
    }

    /* Author ID */

    .author-id-input {
        color: #6F8060;
        font-weight: 700;
        background-color: #EDE7DA;
    }

    /* Validation errors */

    .error-message {
        margin: 6px 0 0;
        color: #A45C6B;
        font-size: 0.82rem;
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

        .edit-author-page {
            max-width: 100%;
        }

        .author-form {
            padding: 22px;
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


<div class="edit-author-page">

    <h1>Edit Author</h1>

    <p>Update the author's information.</p>


    <div class="author-form">

        <form
            action="{{ route('authors.update', $author) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <!-- AUTHOR ID -->

            <div class="form-group">

                <label for="author_id">
                    Author ID
                </label>

                <input
                    type="text"
                    id="author_id"
                    name="author_id"
                    class="form-control author-id-input"
                    value="{{ old('author_id', $author->author_id) }}"
                >

                @error('author_id')
                    <p class="error-message">{{ $message }}</p>
                @enderror

            </div>


            <!-- AUTHOR NAME -->

            <div class="form-group">

                <label for="author_name">
                    Author Name
                </label>

                <input
                    type="text"
                    id="author_name"
                    name="author_name"
                    class="form-control"
                    value="{{ old('author_name', $author->author_name) }}"
                >

                @error('author_name')
                    <p class="error-message">{{ $message }}</p>
                @enderror

            </div>


            <!-- NATIONALITY -->

            <div class="form-group">

                <label for="nationality">
                    Nationality
                </label>

                <input
                    type="text"
                    id="nationality"
                    name="nationality"
                    class="form-control"
                    value="{{ old('nationality', $author->nationality) }}"
                >

                @error('nationality')
                    <p class="error-message">{{ $message }}</p>
                @enderror

            </div>


            <hr class="form-divider">


            <!-- BUTTONS -->

            <div class="form-actions">

                <a
                    href="{{ route('authors.index') }}"
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
