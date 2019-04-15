<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// users
Route::get('/editProfile', 'ChangeProfileDataController@index')->name('ChangeProfile');
Route::post('/editProfile', 'ChangeProfileDataController@change')->name('ChangeUserData');

// Books
Route::get('/home' ,'BooksController@showBooks' )->name('home');
Route::get('/addBook', 'BooksController@showCreationForm')->name('addBook');
Route::post('/createBook', 'BooksController@create')->name('uploadBook');
Route::any('/updateBook/{id}', 'BooksController@patch')->name('updateBook');
Route::get('/showBooks', 'BooksController@showBooks' )->name("showBooks"); // books index
Route::get('/viewBook', 'BooksController@viewBook'  )->name('viewBook');
Route::get('/deleteBook', 'BooksController@deleteBook'  )->name('deleteBook');

// Libraries
Route::get('/myLibrary', 'LibraryController@index')->name('myLibrary');
Route::get('/addToLibrary', 'LibraryController@store' )->name('addTolLibrary');
Route::get('/removeFromLibrary', 'LibraryController@destroy')->name('removeFromLibrary');
