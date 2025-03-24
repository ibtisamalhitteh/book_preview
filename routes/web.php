<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(UserController::class)->group(function(){

    Route::get('users-export-excel', 'generateExcelExport')->name('users.export.excel');
    Route::get('users-export-pdf', 'generatePDFExport')->name('users.export.pdf');

});