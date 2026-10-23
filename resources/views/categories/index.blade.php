@extends('layouts.app')

@section('title', 'Ravenclaw Library')

@section('page-title', 'Categories')

@section('content')

<style>
    /* ===== CATEGORY PAGE ===== */

    .category-page {
        width: 100%;
    }

    /* ---------- PAGE HEADER ---------- */

    .category-header {
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


    /* Add Category */

    .add-button {
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

    .add-button:hover {
        background-color: #5F7053;
        transform: translateY(-1px);
    }


    /* ---------- TABLE ---------- */

    .category-table-container {
        background-color: #F8F2E7;
        border-radius: 16px;
        border: 1px solid #E2D6C7;
        box-shadow: 0 8px 25px rgba(63, 68, 56, 0.07);
        overflow: hidden;
    }

    .category-table {
        width: 100%;
        border-collapse: collapse;
    }

    .category-table th {
        text-align: left;
        padding: 15px 16px;
        background-color: #6F8060;
        color: #F8F2E7;
        font-size: 0.88rem;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .category-table td {
        padding: 15px 16px;
        border-bottom: 1px solid #E8DED2;
        font-size: 0.94rem;
    }

    .category-table tbody tr {
        transition: 0.2s ease;
    }

    .category-table tbody tr:hover {
        background-color: #F5E8E9;
    }

    .category-table tbody tr:last-child td {
        border-bottom: none;
    }


    /* ---------- CATEGORY ID ---------- */

    .category-id {
        color: #6F8060;
        font-weight: 700;
    }


    /* ---------- CATEGORY NAME ---------- */

    .category-name {
        color:#cf767f ;
         /* #3F4438,#33491e,*/
        font-weight: 600;
    }


    /* ---------- DESCRIPTION ---------- */

    .category-description {
        color: #777A69;
        max-width: 500px;
        line-height: 1.5;
    }
    
    /* Total Categories */
    .category-count{
        text-align:center;
        font-weight:600;
        color:#80513a;
    }


    /* ---------- ACTIONS ---------- */

    .category-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }


    /* Edit */

    .edit-button {
        display: inline-block;
        padding: 7px 13px;
        border: none;
        background-color: #E8C1C8;
        color: #7E5360;
        text-decoration: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .edit-button:hover {
        background-color: #D99AA8;
        color: #fffaf5;
    }


    /* Delete */

    .delete-button {
        padding: 7px 13px;
        border: none;
        background-color: #E7D0D3;
        color: #8F5967;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .delete-button:hover {
        background-color: #B87586;
        color: #fffaf5;
    }

</style>

<div class="category-page">

<!-- PAGE HEADER -->

<div class="category-header">

    <form
        action="{{ route('categories.index') }}"
        method="GET"
        class="search-form"
    >

        <input
            type="text"
            name="search"
            placeholder="Search categories..."
            value="{{ request('search') }}"
        >

        <button type="submit">
            Search
        </button>

    </form>


    <a
        href="{{ route('categories.create') }}"
        class="add-button"
    >
        + Add Category
    </a>

</div>


<!-- CATEGORY TABLE -->

<div class="category-table-container">

    <table class="category-table">

        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Description</th>
                <th>Total_Books</th>
                <th>Actions</th>
            </tr>
        </thead>


        <tbody>

            @forelse ($categories as $category)

                <tr> 

                    <td class="category-id">
                        {{ $category->category_id }} 
                    </td> 
                    <!-- id=1 but category_id=C001 -->


                    <td class="category-name">
                        {{ $category->name }}
                    </td>


                    <td class="category-description">
                        {{ $category->description ?? '—' }}
                    </td>
                    <td class="category-count">
                        {{ $category->books_count }}
                    </td>

                    <td>

                        <div class="category-actions">

                            <a
                                href="{{ route('categories.edit', $category) }}"
                                class="edit-button"
                            >
                                Edit
                            </a>


                            <form
                                action="{{ route('categories.destroy', $category) }}"
                                method="POST"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="delete-button"
                                >
                                    Delete
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>


            @empty

                <tr>
                    <td colspan="4" style="text-align: center; padding: 35px; color: #777A69;">
                        No categories found.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>


</div>

@endsection
