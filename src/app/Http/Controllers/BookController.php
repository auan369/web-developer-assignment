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

        $book = Book::findOrFail($id);
        $book->update($request->all());

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
        
        // Return the search results view with the books
        return view('search-results', compact('books', 'searchBy', 'query'));
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
        } elseif ($exportType === 'authors') {
            $books = Book::select('author')->get();
        }
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="books.csv"',
        ];
        
        $callback = function() use ($books, $exportType) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
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
            } elseif ($exportType === 'authors') {
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
        } elseif ($exportType === 'authors') {
            $books = Book::select('author')->get();
        }
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><books></books>');
        
        foreach ($books as $book) {
            $bookXml = $xml->addChild('book');
            if ($exportType === 'all') {
                // $bookXml->addChild('id', $book->id);
                $bookXml->addChild('title', htmlspecialchars($book->title));
                $bookXml->addChild('author', htmlspecialchars($book->author));
                // $bookXml->addChild('created_at', $book->created_at);
                // $bookXml->addChild('updated_at', $book->updated_at);
            } elseif ($exportType === 'titles') {
                $bookXml->addChild('title', htmlspecialchars($book->title));
            } elseif ($exportType === 'authors') {
                $bookXml->addChild('author', htmlspecialchars($book->author));
            }
        }
        
        $headers = [
            'Content-Type' => 'application/xml',
            'Content-Disposition' => 'attachment; filename="books.xml"',
        ];
        
        return response($xml->asXML(), 200, $headers);
    }
}
