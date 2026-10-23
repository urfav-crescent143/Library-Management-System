@extends('layouts.app')

@section('page-title', 'Members')

@section('content')

<style>
    /* ===== EDIT MEMBER PAGE ===== */

    .edit-member-page {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
    }

    .edit-member-page h1 {
        margin: 0 0 6px;
        color: #3F4438;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .edit-member-page > p {
        margin: 0 0 28px;
        color: #777A69;
        font-size: 0.92rem;
    }

    /* Form card */

    .member-form {
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

    /* Inputs and select */

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

    .form-control:focus {
        border-color: #D99AA8;
        box-shadow: 0 0 0 3px rgba(217, 154, 168, 0.12);
    }

    /* Member ID */

    .member-id-input {
        color: #6F8060;
        font-weight: 700;
        background-color: #EDE7DA;
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

        .edit-member-page {
            max-width: 100%;
        }

        .member-form {
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


<div class="edit-member-page">

    <h1>Edit Member</h1>

    <p>Update the member's information.</p>


    <div class="member-form">

        <form
            action="{{ route('members.update', $member->id) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <!-- MEMBER ID -->

            <div class="form-group">

                <label for="member_id">
                    Member ID
                </label>

                <input
                    type="text"
                    id="member_id"
                    name="member_id"
                    class="form-control member-id-input"
                    value="{{ $member->member_id }}"
                >

            </div>


            <!-- MEMBER NAME -->

            <div class="form-group">

                <label for="member_name">
                    Member Name
                </label>

                <input
                    type="text"
                    id="member_name"
                    name="member_name"
                    class="form-control"
                    value="{{ $member->member_name }}"
                >

            </div>


            <!-- EMAIL -->

            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    value="{{ $member->email }}"
                >

            </div>


            <!-- PHONE -->

            <div class="form-group">

                <label for="phone">
                    Phone
                </label>

                <input
                    type="text"
                    id="phone"
                    name="phone"
                    class="form-control"
                    value="{{ $member->phone }}"
                >

            </div>


            <!-- JOIN DATE -->

            <div class="form-group">

                <label for="join_date">
                    Join Date
                </label>

                <input
                    type="date"
                    id="join_date"
                    name="join_date"
                    class="form-control"
                    value="{{ $member->join_date }}"
                >

            </div>


            <!-- STATUS -->

            <div class="form-group">

                <label for="status">
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="form-control"
                >

                    <option
                        value="Active"
                        {{ old('status', $member->status) == 'Active' ? 'selected' : '' }}
                    >
                        Active
                    </option>

                    <option
                        value="Inactive"
                        {{ old('status', $member->status) == 'Inactive' ? 'selected' : '' }}
                    >
                        Inactive
                    </option>

                </select>

            </div>


            <hr class="form-divider">


            <!-- BUTTONS -->

            <div class="form-actions">

                <a
                    href="{{ route('members.index') }}"
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
