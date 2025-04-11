<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Search for Books</div>
                    <div class="card-body">
                        @if(isset($books))
                            <div class="alert alert-info mb-4">
                                Showing results for "{{ $query }}" in {{ $searchBy }} field.
                            </div>
                        @endif
                        
                        @include('partials.search-book')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
