<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th><a href="{{ route('books.title') }}">Title</a></th>
                <th><a href="{{ route('books.author') }}">Author</a></th>
                <th>Delete</th>
                <th>Edit</th>
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
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('books.edit', $book->id) }}" method="GET" class="d-inline">
                        <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
