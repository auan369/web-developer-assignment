<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;


Route::get('/', 'BookController@index')->name('home');
Route::resource('books', 'BookController')->only(['destroy', 'store']);
Route::get('/books/search', 'BookController@search')->name('books.search');

Route::get('/search', function () {
    return view('search');
});


