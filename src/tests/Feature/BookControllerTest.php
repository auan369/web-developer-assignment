<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Controllers\BookController;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class BookControllerTest extends TestCase
{
    use RefreshDatabase; // Use this trait to reset the database for each test

    protected $bookController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookController = new BookController();
    }

    public function testStoreBook()
    {
        $bookData = ['title' => 'New Book', 'author' => 'John Doe'];

        // Create a request
        $request = new Request($bookData);

        // Call the store method
        $response = $this->bookController->store($request);

        // Assert the response is a redirect (HTTP status code 302)
        $this->assertEquals(302, $response->getStatusCode());

        // Assert the redirect location is correct
        $this->assertEquals(route('home'), $response->headers->get('Location'));

        // Assert the success message is in the session
        $this->assertEquals('Book added successfully!', session('success'));

        // Assert the book is in the database
        $this->assertDatabaseHas('books', $bookData);
    }

    public function testUpdateBook()
    {
        $book = Book::create(['title' => 'Old Title', 'author' => 'John Doe']);
        $updatedData = ['title' => 'Updated Title', 'author' => 'John Doe'];

        // Create a request
        $request = new Request($updatedData);

        // Call the update method
        $response = $this->bookController->update($request, $book->id);

        // Assert the response is a redirect (HTTP status code 302)
        $this->assertEquals(302, $response->getStatusCode());

        // Assert the redirect location is correct
        $this->assertEquals(route('home'), $response->headers->get('Location'));

        // Assert the success message is in the session
        $this->assertEquals('Book updated successfully!', session('success'));

        // Assert the book is updated in the database
        $this->assertDatabaseHas('books', $updatedData);
    }

    public function testDeleteBook()
    {
        $book = Book::create(['title' => 'Book to Delete', 'author' => 'John Doe']);

        // Call the delete method
        $response = $this->bookController->destroy($book->id);

        // Assert the response is a redirect (HTTP status code 302)
        $this->assertEquals(302, $response->getStatusCode());

        // Assert the redirect location is correct
        $this->assertEquals(route('home'), $response->headers->get('Location'));

        // Assert the success message is in the session
        $this->assertEquals('Book deleted successfully!', session('success'));

        // Assert the book is no longer in the database
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function testStoreBookValidation()
    {
        $bookData = ['author' => 'John Doe']; // Missing title
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $request = new Request($bookData);
        $response = $this->bookController->store($request);

    }

    public function testStoreBookInvalidData()
    {
        $bookData = ['title' => '', 'author' => 'John Doe']; // Invalid title
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $request = new Request($bookData);
        $response = $this->bookController->store($request);
    }

    public function testUpdateNonExistentBook()
    {
        $updatedData = ['title' => 'Updated Title', 'author' => 'John Doe'];

        // Expecting a ModelNotFoundException
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        $this->bookController->update(new Request($updatedData), 999); // Non-existent ID
    }

    public function testDeleteNonExistentBook()
    {
        // Expecting a ModelNotFoundException
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        $this->bookController->destroy(999); // Non-existent ID
    }
}