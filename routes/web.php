<?php

use App\Http\Controllers\Frontend\DestinationController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\TourController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tour-packages', [TourController::class, 'index'])->name('tour.index');
Route::get('/destinations', [DestinationController::class, 'index'])->name('destination.index');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/about-us', [PageController::class, 'aboutPage'])->name('pages.about');
Route::get('/conatct-us', [PageController::class, 'contactPage'])->name('pages.conatct');

// admin route group
Route::prefix('admin')->name('admin.')->group(function () {
    // dahboard
    Route::get('/', [App\Http\Controllers\Backend\HomeController::class, 'index'])->name('home');
    // Add your admin routes here
});
