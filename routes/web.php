<?php

use App\Http\Controllers\Frontend\DestinationController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\TourController;
use App\Http\Controllers\Frontend\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tour-packages', [TourController::class, 'index'])->name('tour.index');
Route::get('/tour-packages/{tour}', [TourController::class, 'show'])->name('tour.show');
Route::post('/tour-packages/{tour}/reviews', [TourController::class, 'storeReview'])
    ->middleware('throttle:5,1')
    ->name('tour.reviews.store');
Route::post('/tour-packages/{tour}/book', [BookingController::class, 'store'])->middleware('throttle:10,1')->name('booking.store');
Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('booking.show');
Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->middleware('throttle:5,1')->name('booking.cancel');
Route::get('/destinations', [DestinationController::class, 'index'])->name('destination.index');
Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destination.show');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/about-us', [PageController::class, 'aboutPage'])->name('pages.about');
Route::get('/conatct-us', [PageController::class, 'contactPage'])->name('pages.conatct');
