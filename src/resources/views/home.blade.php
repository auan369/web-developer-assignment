<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                    <div class="card-header">Add New Book</div>
                    <div class="card-body">
                        @include('partials.add-book')
                    </div>
                    <div class="card-header">Book List</div>
                    <div class="card-body">
                        @include('partials.book-table', ['books' => $books])
                    </div>
                    <div class="card-header">Export Books</div>
                    <div class="card-body">
                        @include('partials.export-form')
                    </div>

            </div>
        </div>
    </div>
</div>
@endsection
