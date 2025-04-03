<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="content">
        <div>
            <h1 class="title m-b-md">Search for Books</h1>
            {{-- <p>This is the home page.</p> --}}
        </div>
        <div class="add-book">
            <label for="title">Title:</label>
            <input type="text" id="title">
            <label for="author">Author:</label>
            <input type="text" id="author">
            <button id="addButton">Add</button>
    </div>

@endsection
