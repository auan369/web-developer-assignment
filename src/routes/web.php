<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;


Route::get('/', 'BookController@index')->name('home');
Route::get('/books/title', 'BookController@indexTitle')->name('books.title');
Route::get('/books/author', 'BookController@indexAuthor')->name('books.author');
Route::resource('books', 'BookController')->only(['destroy', 'store']);
Route::get('/books/search', 'BookController@search')->name('books.search');

Route::get('/search', function () {
    return view('search');
});


