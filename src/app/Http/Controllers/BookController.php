<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    public function index()
    {
        $books = Book::orderBy('title')->get();  // Retrieve all books sorted by title
        return view('home', compact('books'));  // Pass the books to the home view
    }
    
    public function indexTitle()
    {
        $books = Book::orderBy('title')->get();  // Retrieve all books sorted by title
        return view('home', compact('books'));  // Pass the books to the home view
    }
    
    public function indexAuthor()
    {
        $books = Book::orderBy('author')->get();  // Retrieve all books sorted by author
        return view('home', compact('books'));  // Pass the books to the home view
    }
    
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('home')->with('success', 'Book deleted successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
        ]);

        Book::create($request->all());

        return redirect()->route('home')->with('success', 'Book added successfully!');
    }
    
    public function search(Request $request)
    {
        $request->validate([
            'search_by' => 'required|string|in:title,author',
            'query' => 'required|string',
        ]);
        
        // Get the search parameters as strings
        $searchBy = $request->input('search_by');
        $query = $request->input('query');
        
        // Perform the search
        $books = Book::where($searchBy, 'like', '%' . $query . '%')->get();
        
        return view('search', compact('books'));
    }
}
