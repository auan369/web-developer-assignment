<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="content">
        <div>
            <h1 class="title m-b-md">Search for Books</h1>
            {{-- <p>This is the home page.</p> --}}
        </div>
        @include('partials.search-book')
    </div>

@endsection
