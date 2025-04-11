
<form method="GET" class="d-inline">
    <select name="export_type" class="form-control d-inline-block" style="width: auto;">
        <option value="all">Titles and Authors</option>
        <option value="titles">Titles</option>
        <option value="authors">Authors</option>
    </select>
    <button type="submit" formaction="{{ route('books.export.csv') }}" class="btn btn-success">Export CSV</button>
    <button type="submit" formaction="{{ route('books.export.xml') }}" class="btn btn-info">Export XML</button>
</form>
