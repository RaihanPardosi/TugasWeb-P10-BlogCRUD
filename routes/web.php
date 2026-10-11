<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('posts.index'))->name('home');

// Rute tambahan untuk soft delete (harus menyertakan data yang sudah di-trash).
Route::patch('posts/{post}/restore', [PostController::class, 'restore'])
    ->withTrashed()
    ->name('posts.restore');

Route::delete('posts/{post}/force', [PostController::class, 'forceDelete'])
    ->withTrashed()
    ->name('posts.force-delete');

Route::resource('posts', PostController::class);
