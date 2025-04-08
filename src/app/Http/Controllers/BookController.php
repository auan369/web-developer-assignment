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
        $books = Book::all();  // Retrieve all books
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
}
