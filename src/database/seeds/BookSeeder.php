<?php

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run()
    {
        // Add multiple books here
        Book::create([
            'title' => 'The Great Gatsby',
            'author' => 'F. Scott Fitzgerald',
            // 'description' => 'A novel set in the Roaring Twenties.',
            // 'isbn' => '9780743273565',
            // 'published_year' => 1925
        ]);

        Book::create([
            'title' => 'To Kill a Mockingbird',
            'author' => 'Harper Lee',
            // 'description' => 'A story about racial injustice in the American South.',
            // 'isbn' => '9780061120084',
            // 'published_year' => 1960
        ]);

        Book::create([
            'title' => '1984',
            'author' => 'George Orwell',
            // 'description' => 'A dystopian social science fiction novel.',
            // 'isbn' => '9780451524935',
            // 'published_year' => 1949
        ]);
    }
}
