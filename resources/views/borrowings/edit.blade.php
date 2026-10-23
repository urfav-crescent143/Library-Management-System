@extends('layouts.app')

@section('title', 'Edit Borrowing')

@section('page-title', 'Edit Borrowing')

@section('content')

<div class="form-container">

    <h2>Edit Borrowing</h2>

    <form action="{{ route('borrowings.update', $borrowing->id) }}" method="POST">

        @csrf
        @method('PUT')

        <!-- Borrowing ID -->
        <div>
            <label>Borrowing ID</label>

            <input
                type="text"
                value="{{ $borrowing->borrowing_id }}"
                readonly
            >
        </div>

        <br>

        <!-- Member -->
        <div>
            <label>Member</label>

            <select name="member_id" required>

                @foreach ($members as $member)

                    <option
                        value="{{ $member->id }}"
                        {{ $borrowing->member_id == $member->id ? 'selected' : '' }}
                    >
                        {{ $member->member_name }}
                    </option>

                @endforeach

            </select>
        </div>

        <br>

        <!-- Book -->
        <div>
            <label>Book</label>

            <input
                type="text"
                value="{{ $borrowing->book->title }}"
                readonly
            >
        </div>

        <br>

        <!-- Borrowed Date -->
        <div>
            <label>Borrowed Date</label>

            <input
                type="date"
                name="borrowed_at"
                value="{{ \Carbon\Carbon::parse($borrowing->borrowed_at)->format('Y-m-d') }}"
                required
            >
        </div>

        <br>

        <!-- Due Date -->
        <div>
            <label>Due Date</label>

            <input
                type="date"
                name="due_date"
                value="{{ \Carbon\Carbon::parse($borrowing->due_date)->format('Y-m-d') }}"
                required
            >
        </div>

        <br>

        <button type="submit">
            Save Changes
        </button>

    </form>

</div>

@endsection