<?php

use App\Http\Controllers\EntryController;
use App\Http\Controllers\VisitorController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // })->name('dashboard');
    Route::get('/', [VisitorController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [VisitorController::class, 'index'])->name('dashboard');
    Route::get('/visitor/create', [VisitorController::class,'create'])->name('visitor.create');
    Route::post('/visitor', [VisitorController::class,'store'])->name('visitor.store');
    Route::get('/visitor/{visitor}/edit', [VisitorController::class, 'edit'])->name('visitor.edit');
    Route::put('/visitor/{visitor}', [VisitorController::class, 'update'])->name('visitor.update');
    Route::delete('/visitor/{visitor}', [VisitorController::class, 'destroy'])->name('visitor.delete');

    Route::get('/entry', [EntryController::class, 'index'])->name('entry.index');
    Route::get('/entry/create', [EntryController::class, 'create'])->name('entry.create');
    Route::post('/entry', [EntryController::class, 'store'])->name('entry.store');
    Route::get('/entry/{entry}/edit', [EntryController::class, 'edit'])->name('entry.edit');
    Route::put('/entry/{entry}', [EntryController::class, 'update'])->name('entry.update');
    Route::delete('/entry/{entry}', [EntryController::class, 'destroy'])->name('entry.delete');
});
