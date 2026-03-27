<?php

use Illuminate\Support\Facades\Route;


Route::get('/login', [App\Http\Controllers\Backend\AuthController::class, 'showLoginForm'])->name('login');

Route::middleware(['isAdmin'])->group(function () {
    Route::get('/', [App\Http\Controllers\Backend\HomeController::class, 'index'])->name('dashboard');

    // hero-slider
    Route::prefix('website')->name('website.')->group(function () {
        Route::get('hero-slider', [App\Http\Controllers\Backend\WebsiteController::class, 'heroSlider'])->name('slider.index');
    });

    // location
    Route::prefix('location')->name('location.')->group(function () {
        Route::get('country', [App\Http\Controllers\Backend\LocationController::class, 'country'])->name('country.index');
        Route::get('city', [App\Http\Controllers\Backend\LocationController::class, 'city'])->name('city.index');
    });


});
