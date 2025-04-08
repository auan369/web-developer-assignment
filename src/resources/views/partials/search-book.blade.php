<div class="search-book">
    {{-- <form action="{{ route('books.search') }}" method="GET"> --}}
    <form action="{{ route('books.search') }}" method="GET">
        @csrf
        <label for="query">Search by:</label>
        <select name="search_by">
            <option value="title">Title</option>
            <option value="author">Author</option>
        </select>
        <input type="text" name="query" placeholder="Type your search">
        <button type="submit">Search</button>
    </form>

    @if(isset($books))
        @include('partials.book-table', ['books' => $books])
    @endif
</div>
