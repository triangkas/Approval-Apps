<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;

Route::get('/', function () {
    return redirect(route('dashboard'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('request')->name('request.')->group(function () {
        Route::get('/data-json', [RequestController::class, 'dataJson'])->name('data-json');
        Route::resource('/', RequestController::class)->parameters(['' => 'id']);
    });

    Route::prefix('approval')->name('approval.')->group(function () {
        Route::get('/data-json', [ApprovalController::class, 'dataJson'])->name('data-json');
        Route::post('/status/{id}', [ApprovalController::class, 'status'])->name('status');
        Route::resource('/', ApprovalController::class)->parameters(['' => 'id']);
    });
});

require __DIR__.'/auth.php';
