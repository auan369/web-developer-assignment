<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="content">
        <div>
            <h1 class="title m-b-md">Books</h1>
            <p>This is the home page.</p>
        </div>
        <h2>Add a New Book</h2>
            @if(session('success'))
                <p style="color: green;">{{ session('success') }}</p>
            @endif

            <form action="{{ route('books.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label for="title">Title:</label>
                <input type="text" name="title" required>

                <label for="author">Author:</label>
                <input type="text" name="author" required>

                <button type="submit">Add Book</button>
            </form>
    </div>
     <!-- Include the book table partial -->
     @include('partials.book-table', ['books' => $books])
@endsection
