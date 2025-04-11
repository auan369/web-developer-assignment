<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', 'BookController@index')->name('home');
Route::get('/books/title', 'BookController@indexTitle')->name('books.title');
Route::get('/books/author', 'BookController@indexAuthor')->name('books.author');
Route::get('/books/export/csv', 'BookController@exportCsv')->name('books.export.csv');
Route::get('/books/export/xml', 'BookController@exportXml')->name('books.export.xml');
Route::resource('books', 'BookController')->only(['destroy', 'store', 'edit', 'update']);
Route::get('/books/search', 'BookController@search')->name('books.search');

// Search page route
Route::get('/search', 'BookController@showSearchForm')->name('search');


