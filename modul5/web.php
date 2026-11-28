<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookWebController;

Route::get('/', function () {
    return view('welcome');
});

// Routes the browser URL (/books) to the BookWebController index method
Route::get('/books', [BookWebController::class, 'index'])->name('books.index');
