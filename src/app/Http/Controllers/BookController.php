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
        Book::deleteBook($id);
        
        return redirect()->route('home')->with('success', 'Book deleted successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
        ]);

        $book = Book::createBook($request->all());
        
        return redirect()->route('home')->with('success', 'Book added successfully!');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
        ]);

        $book = Book::updateBook($id, $request->all());
        
        return redirect()->route('home')->with('success', 'Book updated successfully!');
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
        $books = Book::where($searchBy, 'like', "%{$query}%")->get();
        
        // Return the search view with the books
        return view('search', compact('books', 'searchBy', 'query'));
    }
    
    public function showSearchForm()
    {
        return view('search');
    }
    
    public function exportCsv(Request $request)
    {
        $request->validate([
            'export_type' => 'required|string|in:all,titles,authors',
        ]);
        $exportType = $request->input('export_type');

        if ($exportType === 'all') {
            $books = Book::all();
        } elseif ($exportType === 'titles') {
            $books = Book::select('title')->get();
        } else {
            $books = Book::select('author')->get();
        }

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=books.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($books, $exportType) {
            $file = fopen('php://output', 'w');
            
            if ($exportType === 'all') {
                fputcsv($file, ['Title', 'Author']);
                foreach ($books as $book) {
                    fputcsv($file, [$book->title, $book->author]);
                }
            } elseif ($exportType === 'titles') {
                fputcsv($file, ['Title']);
                foreach ($books as $book) {
                    fputcsv($file, [$book->title]);
                }
            } else {
                fputcsv($file, ['Author']);
                foreach ($books as $book) {
                    fputcsv($file, [$book->author]);
                }
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    public function exportXml(Request $request)
    {
        $request->validate([
            'export_type' => 'required|string|in:all,titles,authors',
        ]);
        $exportType = $request->input('export_type');

        if ($exportType === 'all') {
            $books = Book::all();
        } elseif ($exportType === 'titles') {
            $books = Book::select('title')->get();
        } else {
            $books = Book::select('author')->get();
        }

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><books></books>');

        foreach ($books as $book) {
            $bookNode = $xml->addChild('book');
            if ($exportType === 'all' || $exportType === 'titles') {
                $bookNode->addChild('title', htmlspecialchars($book->title));
            }
            if ($exportType === 'all' || $exportType === 'authors') {
                $bookNode->addChild('author', htmlspecialchars($book->author));
            }
        }

        $headers = [
            "Content-type" => "text/xml",
            "Content-Disposition" => "attachment; filename=books.xml",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        return response($xml->asXML(), 200, $headers);
    }
}
