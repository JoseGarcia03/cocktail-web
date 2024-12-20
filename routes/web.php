<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CocktailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::redirect('/', '/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [CocktailController::class, 'index'])->name('home');
    Route::get('/cocktails', [CocktailController::class, 'search'])->name('cocktails.search');
    Route::post('/cocktails/save', [CocktailController::class, 'save'])->name('cocktails.save');
    Route::delete('/cocktails/delete', [CocktailController::class, 'destroy'])->name('cocktails.delete');
    Route::get('/saved', [CocktailController::class, 'saved'])->name('cocktails.saved');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
