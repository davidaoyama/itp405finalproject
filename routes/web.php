<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;


Route::get('/', [ShowController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/shows', [ShowController::class, 'index'])->name('shows.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/shows/create', [ShowController::class, 'create'])->name('shows.create');
    Route::post('/shows', [ShowController::class, 'store'])->name('shows.store');
    Route::get('/shows/{show}/edit', [ShowController::class, 'edit'])->name('shows.edit');
    Route::put('/shows/{show}', [ShowController::class, 'update'])->name('shows.update');
    Route::delete('/shows/{show}', [ShowController::class, 'destroy'])->name('shows.destroy');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{show}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{show}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

});


Route::get('/shows/{show}', [ShowController::class, 'show'])->name('shows.show');


require __DIR__.'/auth.php';
