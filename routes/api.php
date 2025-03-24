<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GoogleBooksApiController;
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


Route::middleware(['auth:api'])->prefix('/v1')->name('auth.user')
    ->controller(GoogleBooksApiController::class)
    ->group(function () {
        //Route::post('/logout', 'logout')->name('logout');
        Route::get('/fetchbooks/{batch_size}', 'fetchBooks')->name('fetch.books');

});