@extends('layouts.app')

@section('page-title', 'Categories')

@section('content')

<style>
    /* ===== EDIT CATEGORY PAGE ===== */

    .edit-category-page {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
    }

    .edit-category-page h1 {
        margin: 0 0 6px;
        color: #3F4438;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .edit-category-page > p {
        margin: 0 0 28px;
        color: #777A69;
        font-size: 0.92rem;
    }

    /* Form card */

    .category-form {
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
        transition: 0.2s ease;
        box-sizing: border-box;
    }

    .form-control::placeholder {
        color: #999889;
    }

    .form-control:focus {
        border-color: #D99AA8;
        box-shadow: 0 0 0 3px rgba(217, 154, 168, 0.12);
    }

    /* Description */

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
        line-height: 1.5;
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

    .update-button {
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

    .update-button:hover {
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

        .edit-category-page {
            max-width: 100%;
        }

        .category-form {
            padding: 22px;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .update-button,
        .cancel-button {
            width: 100%;
            text-align: center;
        }
    }
</style>


<div class="edit-category-page">

    <h1>Edit Category</h1>

    <p>Update the information for this category.</p>


    <div class="category-form">

        <form
            action="{{ route('categories.update', $category) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <!-- CATEGORY NAME -->

            <div class="form-group">

                <label for="name">
                    Category Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $category->name) }}"
                    required
                >

            </div>


            <!-- DESCRIPTION -->

            <div class="form-group">

                <label for="description">
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    class="form-control"
                >{{ old('description', $category->description) }}</textarea>

            </div>


            <hr class="form-divider">


            <!-- BUTTONS -->

            <div class="form-actions">

                <a
                    href="{{ route('categories.index') }}"
                    class="cancel-button"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="update-button"
                >
                    Update Category
                </button>

            </div>

        </form>

    </div>

</div>
@endsection