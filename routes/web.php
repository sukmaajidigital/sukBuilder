<?php

use App\Http\Controllers\Dashboard\DynamicColumnController;
use App\Http\Controllers\Dashboard\DynamicTableController;
use App\Http\Controllers\DynamicResourceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::resource('tables', DynamicTableController::class);

        Route::post('tables/{table}/columns', [DynamicColumnController::class, 'store'])->name('columns.store');
    });
    Route::prefix('data/{table_slug}')->name('dynamic.')->group(function () {
        Route::get('/', [DynamicResourceController::class, 'index'])->name('index');
        Route::get('/create', [DynamicResourceController::class, 'create'])->name('create');
        Route::post('/', [DynamicResourceController::class, 'store'])->name('store');
        // Route untuk edit, update, destroy akan ditambahkan nanti
    });
});

require __DIR__ . '/auth.php';
