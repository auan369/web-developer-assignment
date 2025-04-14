<?php

namespace App\Models;


// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // use HasFactory;
    protected $fillable = ['title', 'author'];

    // Method to create a book
    public static function createBook(array $data)
    {
        return self::create($data);
    }

    // Method to update a book
    public static function updateBook($id, array $data)
    {
        $book = self::findOrFail($id);
        $book->update($data);
        return $book;
    }

    // Method to delete a book
    public static function deleteBook($id)
    {
        $book = self::findOrFail($id);
        return $book->delete();
    }
}
