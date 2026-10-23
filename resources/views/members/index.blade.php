@extends('layouts.app')

@section('title', 'Ravenclaw Library')

@section('page-title', 'Members')

@section('content')

<style>
    /* scroll thingy invisible*/

    .members-table-container {
        scrollbar-width: none;
    }

    .members-table-container::-webkit-scrollbar {
        display: none;
    }
    

    /* ===== MEMBERS PAGE ===== */

    .members-page {
        width: 100%;
        min-width: 0;
        color: #3F4438;
    }

    /* ---------- TOOLBAR ---------- */

    .members-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 24px;
    }

    /* Search */

    .search-form {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        max-width: 440px;
        min-width: 0;
    }

    .search-form input {
        flex: 1;
        min-width: 0;
        width: 100%;
        padding: 11px 14px;
        border: 1px solid #D8C8B7;
        border-radius: 10px;
        background-color: #F8F4EC;
        color: #3F4438;
        outline: none;
        font-size: 0.92rem;
        transition: border-color 0.2s ease,
                    box-shadow 0.2s ease;
    }

    .search-form input::placeholder {
        color: #9A8B7B;
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
        color: #FFFDF8;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s ease,
                    transform 0.2s ease;
    }

    .search-form button:hover {
        background-color: #B87586;
        transform: translateY(-1px);
    }

    /* Add Member */

    .add-member-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 11px 18px;
        background-color: #6F8060;
        color: #FFFDF8;
        text-decoration: none;
        border: 1px solid #6F8060;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        white-space: nowrap;
        transition: background-color 0.2s ease,
                    transform 0.2s ease;
    }

    .add-member-btn:hover {
        background-color: #5F7053;
        border-color: #5F7053;
        color: #FFFDF8;
        transform: translateY(-1px);
    }

    /* ---------- TABLE CONTAINER ---------- */

    .members-table-container {
        width: 100%;
        overflow-x: auto;
        background-color: #F8F4EC;
        border: 1px solid #E2D6C7;
        border-radius: 14px;
        box-shadow: 0 5px 18px rgba(63, 68, 56, 0.05);
    }

    /* ---------- TABLE ---------- */

    .members-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .members-table thead {
        background-color: #6F8060;
        color: #FFFDF8;
    }

    .members-table th {
        padding: 15px 17px;
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.35px;
        white-space: nowrap;
    }

    .members-table td {
        padding: 15px 17px;
        border-bottom: 1px solid #E8DED2;
        color: #4A463D;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .members-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .members-table tbody tr:hover {
        background-color: #F5E8E9;
    }

    .members-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Member ID */

    .member-id {
        color: #6F8060;
        font-weight: 700;
        white-space: nowrap;
    }

    /* Member name */

    .member-name {
        color: #593C33;
        font-weight: 600;
    }

    /* Email and phone */

    .member-contact {
        color: #6B6256;
    }

    /* Join date */

    .member-date {
        color: #776A5C;
        white-space: nowrap;
        font-size: 0.87rem;
    }

    /* ---------- STATUS ---------- */

    .status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 11px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-active {
        background-color: #E5EBDD;
        color: #526747;
        border: 1px solid #CCD8C2;
    }

    .status-inactive {
        background-color: #F3E0E3;
        color: #8F5967;
        border: 1px solid #E8C1C8;
    }

    /* ---------- EDIT BUTTON ---------- */

    .edit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 14px;
        background-color: #F3E0E3;
        color: #7E5360;
        border: 1px solid #E8C1C8;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.83rem;
        font-weight: 600;
        white-space: nowrap;
        transition: background-color 0.2s ease,
                    color 0.2s ease;
    }

    .edit-btn:hover {
        background-color: #D99AA8;
        border-color: #D99AA8;
        color: #FFFDF8;
    }

    /* ---------- EMPTY STATE ---------- */

    .empty-state {
        padding: 38px 20px !important;
        text-align: center;
        color: #8A7768 !important;
        font-size: 0.92rem !important;
    }

    /* ---------- RESPONSIVE ---------- */

    @media (max-width: 768px) {
        .members-toolbar {
            align-items: stretch;
        }

        .search-form {
            max-width: none;
            flex-basis: 100%;
        }

        .add-member-btn {
            align-self: flex-start;
        }

        .members-table th,
        .members-table td {
            padding: 12px 14px;
        }
    }

    @media (max-width: 420px) {
        .search-form {
            flex-wrap: wrap;
        }

        .search-form input {
            flex-basis: 100%;
        }

        .search-form button {
            width: 100%;
        }
    }
</style>

<div class="members-page">

    {{-- Search and Add Member --}}

    <div class="members-toolbar">

        <form
            action="{{ route('members.index') }}"
            method="GET"
            class="search-form"
        >
            <input
                type="text"
                name="search"
                placeholder="Search members..."
                value="{{ request('search') }}"
            >

            <button type="submit">
                Search
            </button>
        </form>

        <a
            href="{{ route('members.create') }}"
            class="add-member-btn"
        >
            + Add Member
        </a>

    </div>

    {{-- Members Table --}}

    <div class="members-table-container">

        <table class="members-table">

            <thead>
                <tr>
                    <th>Member ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Join Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($members as $member)

                    <tr>

                        <td>
                            <span class="member-id">
                                {{ $member->member_id }}
                            </span>
                        </td>

                        <td>
                            <span class="member-name">
                                {{ $member->member_name }}
                            </span>
                        </td>

                        <td>
                            <span class="member-contact">
                                {{ $member->email }}
                            </span>
                        </td>

                        <td>
                            <span class="member-contact">
                                {{ $member->phone }}
                            </span>
                        </td>

                        <td>
                            <span class="member-date">
                                {{ $member->join_date->format('D, d M Y') }}
                            </span>
                        </td>

                        <td>
                            @if ($member->status === 'Active')

                                <span class="status status-active">
                                    Active
                                </span>

                            @else

                                <span class="status status-inactive">
                                    Inactive
                                </span>

                            @endif
                        </td>

                        <td>
                            <a
                                href="{{ route('members.edit', $member->id) }}"
                                class="edit-btn"
                            >
                                Edit
                            </a>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="empty-state">
                            No members found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

