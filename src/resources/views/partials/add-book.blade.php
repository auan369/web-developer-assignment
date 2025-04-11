@include('partials.success-message')
<form method="POST" action="{{ route('books.store') }}">
    @csrf
    <div class="form-group row">
        <label for="title" class="col-md-2 col-form-label text-md-right">Title</label>
        <div class="col-md-6">
            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="author" class="col-md-2 col-form-label text-md-right">Author</label>
        <div class="col-md-6">
            <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author') }}" required autocomplete="author">
            @error('author')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-primary">
                Add Book
            </button>
        </div>
    </div>
</form>