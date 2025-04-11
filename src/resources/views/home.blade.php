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

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Books</div>

                            <div class="card-body">
                                
                                <form method="POST" action="{{ route('books.store') }}">
                                    @csrf
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <label for="title">Title:</label>
                                    <input type="text" name="title" required>
                                    
                                    <label for="author">Author:</label>
                                    <input type="text" name="author" required>
                                    
                                    <button type="submit">Add Book</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Include the book table partial -->
        @include('partials.book-table', ['books' => $books])
        @include('partials.export-form')
@endsection
