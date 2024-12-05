<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


Route::resource('categories', CategoryController::class);
Route::resource('books', BookController::class);
Route::get('books/{book}/download', [BookController::class, 'download'])->name('books.download');
