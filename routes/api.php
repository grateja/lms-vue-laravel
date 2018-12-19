<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/books/generate-id', 'BooksController@generateTypeID');

Route::resource('books', 'BooksController');

Route::resource('deweys', 'DeweysController');
Route::resource('publishers', 'PublishersController');
Route::resource('publishing-places', 'PublishingPlacesController');
Route::resource('categories', 'CategoriesController');
Route::resource('book-conditions', 'BookConditionsController');

Route::resource('individual-books', 'IndividualBooksController');

Route::group(['prefix' => 'autocomplete'], function(){
    Route::get('/publishers', 'PublishersController@autocomplete');
    Route::get('/deweys', 'DeweysController@autocomplete');
    Route::get('/categories', 'CategoriesController@autocomplete');
});