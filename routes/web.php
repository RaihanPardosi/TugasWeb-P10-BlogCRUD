<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/posts');

// Route tambahan (soft delete) HARUS di atas resource supaya "posts/trash"
// tidak ketangkap sebagai posts/{post}.
Route::get('posts/trash', [PostController::class, 'trash'])->name('posts.trash');
Route::patch('posts/{post}/restore', [PostController::class, 'restore'])
    ->name('posts.restore')->withTrashed();
Route::delete('posts/{post}/force', [PostController::class, 'forceDelete'])
    ->name('posts.force-delete')->withTrashed();

// Menghasilkan 7 named route: posts.index, create, store, show, edit, update, destroy
Route::resource('posts', PostController::class);
