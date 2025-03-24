<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GoogleBooksApiController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BookController;
/*

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

*/

Route::prefix('/v1')->name('auth.user')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('/login', 'login')->name('loginuser');
        Route::post('/register', 'register')->name('registeruser');

});

Route::middleware(['auth:api'])->prefix('/v1')->name('auth.user')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('/logout', 'logout')->name('logout');
        Route::get('/profile', 'profile')->name('profile');

});


Route::middleware(['auth:api'])->prefix('/v1')->name('googlebooks')
    ->controller(GoogleBooksApiController::class)
    ->group(function () {
        //Route::post('/logout', 'logout')->name('logout');
        Route::get('/fetchbooks/{batch_size}', 'fetchBooks')->name('fetch.books');

});

Route::middleware(['auth:api'])->prefix('/v1/users')->name('users')
    ->controller(UserController::class)
    ->group(function () {
        Route::get('/history', 'getHistory')->name('historybooks.user');

});


Route::middleware(['auth:api'])->prefix('/v1/books')->name('books')
    ->controller(BookController::class)
    ->group(function () {
        Route::get('/', 'index')->name('book.list');
        Route::post('/review', 'review')->name('book.review');
        Route::post('/rating', 'rating')->name('book.rating');
        Route::get('/view/{id}', 'show')->name('book.view');
        Route::get('/delete/{id}', 'destroy')->name('book.destroy');
});
    

    