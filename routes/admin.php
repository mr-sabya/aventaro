<?php

use Illuminate\Support\Facades\Route;


Route::get('/login', [App\Http\Controllers\Backend\AuthController::class, 'showLoginForm'])->name('login');

Route::middleware(['isAdmin'])->group(function () {
    Route::get('/', [App\Http\Controllers\Backend\HomeController::class, 'index'])->name('dashboard');

    // hero-slider
    Route::prefix('website')->name('website.')->group(function () {
        Route::get('hero-slider', [App\Http\Controllers\Backend\WebsiteController::class, 'heroSlider'])->name('slider.index');

        // about section
        Route::get('about-section', [App\Http\Controllers\Backend\WebsiteController::class, 'aboutSection'])->name('about-section.index');

        // partner
        Route::get('partners', [App\Http\Controllers\Backend\WebsiteController::class, 'partner'])->name('partner.index');

        // brand section
        Route::get('brand-section', [App\Http\Controllers\Backend\WebsiteController::class, 'brandSection'])->name('brand-section.index');

        // trending destination section
        Route::get('trending-destination-section', [App\Http\Controllers\Backend\WebsiteController::class, 'trendingDestinationSection'])->name('trending-section.index');
    });

    // location
    Route::prefix('location')->name('location.')->group(function () {
        Route::get('country', [App\Http\Controllers\Backend\LocationController::class, 'country'])->name('country.index');
        Route::get('city', [App\Http\Controllers\Backend\LocationController::class, 'city'])->name('city.index');
    });

    // settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('currency', [App\Http\Controllers\Backend\SettingController::class, 'currency'])->name('currency.index');
        Route::get('language', [App\Http\Controllers\Backend\SettingController::class, 'language'])->name('language.index');
    });

    // destinations
    Route::prefix('destinations')->name('destinations.')->group(function () {
        Route::get('/', [App\Http\Controllers\Backend\DestinationController::class, 'index'])->name('index');
        Route::get('/faq', [App\Http\Controllers\Backend\DestinationController::class, 'faq'])->name('faq');
    });

    // tours
    Route::prefix('tours')->name('tours.')->group(function () {
        Route::get('/', [App\Http\Controllers\Backend\TourController::class, 'index'])->name('index');
        Route::get('/amenities', [App\Http\Controllers\Backend\TourController::class, 'amenities'])->name('amenities');
        Route::get('/plans/{id}', [App\Http\Controllers\Backend\TourController::class, 'plans'])->name('plans');
    });
});
