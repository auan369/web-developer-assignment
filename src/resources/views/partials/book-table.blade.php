<!-- resources/views/partials/book-table.blade.php -->

<table>
    <thead>
        <tr>
            <th><a href="{{ route('books.title') }}">Title</a></th>
            <th><a href="{{ route('books.author') }}">Author</a></th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
