<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostController::class)
        ->except(['show']);
});

// Route publique pour lecture
Route::get('/posts/{article:slug}', [PostController::class, 'show'])
    ->name('posts.show');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
