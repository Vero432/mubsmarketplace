<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AdminController;

// Visitors see the landing page; logged-in users go straight to Browse
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('listings.index')
        : view('welcome');
});

// Anything that still points to /dashboard goes to Browse
Route::get('/dashboard', fn () => redirect()->route('listings.index'))
    ->middleware('auth')
    ->name('dashboard');
    
Route::middleware('auth')->get('/home', function(){ return view('home');})->name('home');


Route::middleware(['auth', 'active'])->group(function (){
    Route::get('/home', fn ()=> redirect()->route('listings.index'))->name('home');
    Route::view('/guidelines', 'guidelines')->name('guidelines');
    
    //listings
    Route::get('/my-listings', [ListingController::class, 'mine'])->name('listings.mine');
    Route::patch('/listings/{listing}/status', [ListingController::class, 'updateStatus'])->name('listings.status');
    Route::resource('listings', ListingController::class);

    //messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

    //reports
    Route::get('/listings/{listing}/report', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/listings/{listing}/report', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/my-reports', [ReportController::class, 'mine'])->name('reports.mine');

    //sellers and ratings
    Route::get('/sellers/{user}', [SellerController::class, 'show'])->name('sellers.show');
    Route::post('/listings/{listing}/rate', [RatingController::class, 'store'])->name('ratings.store');

    //administrators only
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/status', [AdminController::class, 'updateUser'])->name('users.status');

    Route::get('/listings', [AdminController::class, 'listings'])->name('listings');
    Route::delete('/listings/{listing}', [AdminController::class, 'destroyListing'])->name('listings.destroy');

    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::patch('/reports/{report}', [AdminController::class, 'updateReport'])->name('reports.update');

    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');
});
});

