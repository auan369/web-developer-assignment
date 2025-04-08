<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class BookTest extends TestCase
{
    /**
     * Test that we can create and retrieve a book.
     *
     * @return void
     */
    public function testCreateAndRetrieveBook()
    {
        // Verify we're using the test database
        $this->assertEquals('laravel_test', DB::connection('testing')->getDatabaseName());
        
        // Create a new book
        $book = Book::on('testing')->create([
            'title' => 'Test Book',
            'author' => 'Test Author'
        ]);
        
        // Assert the book was created
        $this->assertNotNull($book->id);
        $this->assertEquals('Test Book', $book->title);
        $this->assertEquals('Test Author', $book->author);
        
        // Retrieve the book from the database
        $retrievedBook = Book::on('testing')->find($book->id);
        
        // Assert the retrieved book matches the created book
        $this->assertEquals($book->id, $retrievedBook->id);
        $this->assertEquals($book->title, $retrievedBook->title);
        $this->assertEquals($book->author, $retrievedBook->author);
    }
    
    /**
     * Test that we can update a book.
     *
     * @return void
     */
    public function testUpdateBook()
    {
        // Create a book
        $book = Book::on('testing')->create([
            'title' => 'Original Title',
            'author' => 'Original Author'
        ]);
        
        // Update the book
        $book->update([
            'title' => 'Updated Title',
            'author' => 'Updated Author'
        ]);
        
        // Refresh the model from the database
        $book->refresh();
        
        // Assert the book was updated
        $this->assertEquals('Updated Title', $book->title);
        $this->assertEquals('Updated Author', $book->author);
    }
    
    /**
     * Test that we can delete a book.
     *
     * @return void
     */
    public function testDeleteBook()
    {
        // Create a book
        $book = Book::on('testing')->create([
            'title' => 'Book To Delete',
            'author' => 'Author To Delete'
        ]);
        
        // Get the book ID
        $bookId = $book->id;
        
        // Delete the book
        $book->delete();
        
        // Assert the book no longer exists
        $this->assertNull(Book::on('testing')->find($bookId));
    }
}