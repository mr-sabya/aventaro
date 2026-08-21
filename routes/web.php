<?php

use App\Http\Controllers\Frontend\DestinationController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\TourController;
use App\Http\Controllers\Frontend\TeamController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\EngagementController;
use App\Http\Controllers\Frontend\PreferenceController;
use App\Http\Controllers\Frontend\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
Route::post('/preferences', PreferenceController::class)->name('preferences.update');
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
Route::get('/news/{post}', [NewsController::class, 'show'])->name('news.show');
Route::get('/about-us', [PageController::class, 'aboutPage'])->name('pages.about');
Route::get('/faq', [PageController::class, 'faq'])->name('pages.faq');
Route::get('/privacy-policy', [PageController::class, 'show'])->defaults('slug', 'privacy-policy')->name('pages.privacy');
Route::get('/terms-and-conditions', [PageController::class, 'show'])->defaults('slug', 'terms')->name('pages.terms');
Route::get('/team', [TeamController::class, 'index'])->name('team.index');
Route::get('/team/{member}', [TeamController::class, 'show'])->name('team.show');
Route::get('/contact-us', [PageController::class, 'contactPage'])->name('pages.contact');
Route::redirect('/conatct-us', '/contact-us', 301);
Route::post('/contact-us', [EngagementController::class, 'contact'])->middleware('throttle:5,1')->name('contact.store');
Route::post('/appointments', [EngagementController::class, 'contact'])->middleware('throttle:5,1')->name('appointment.store');
Route::post('/newsletter', [EngagementController::class, 'subscribe'])->middleware('throttle:5,1')->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{subscriber}', [EngagementController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
Route::post('/newsletter/unsubscribe/{subscriber}', [EngagementController::class, 'destroySubscription'])->name('newsletter.destroy');
Route::get('/search', [EngagementController::class, 'search'])->name('search');
