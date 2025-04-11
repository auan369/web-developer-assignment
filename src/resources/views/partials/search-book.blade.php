<div class="search-book">
    <form action="{{ route('books.search') }}" method="GET" class="form-inline justify-content-center mb-4">
        {{-- <div class="form-group mx-2"> --}}
            <label for="search_by" class="mr-2">Search by:</label>
            <select name="search_by" id="search_by" class="form-control">
                <option value="title" {{ isset($searchBy) && $searchBy === 'title' ? 'selected' : '' }}>Title</option>
                <option value="author" {{ isset($searchBy) && $searchBy === 'author' ? 'selected' : '' }}>Author</option>
            </select>
        {{-- </div> --}}
        {{-- <div class="form-group mx-2"> --}}
            <input type="text" name="query" id="query" class="form-control" placeholder="Type your search" value="{{ $query ?? '' }}" required>
        {{-- </div> --}}
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    @if(isset($books))
        @if($books->count() > 0)
            @include('partials.book-table', ['books' => $books])
        @else
            <div class="alert alert-warning">
                No books found matching your search criteria.
            </div>
        @endif
    @endif
</div>
