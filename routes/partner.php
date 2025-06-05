<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Partner\Product\ProductController;

Route::prefix('partner')->name('partner.')->group(function () {
    Route::get('/dashboard', function () {
        return view('partner.dashboard');
    })->name('dashboard');

    Route::resource('products', ProductController::class);
});