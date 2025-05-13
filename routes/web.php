<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Profile\CompanyProfileController;
use App\Http\Controllers\Profile\JobseekerProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Profile Creation Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/jobseeker/profile/create', [App\Http\Controllers\Profile\JobseekerProfileController::class, 'create'])->name('jobseeker.profile.create');
    Route::post('/jobseeker/profile', [App\Http\Controllers\Profile\JobseekerProfileController::class, 'store'])->name('jobseeker.profile.store');
    Route::get('/jobseeker/profile/edit', [App\Http\Controllers\Profile\JobseekerProfileController::class, 'edit'])->name('jobseeker.profile.edit');
    Route::put('/jobseeker/profile', [App\Http\Controllers\Profile\JobseekerProfileController::class, 'update'])->name('jobseeker.profile.update');

    Route::get('/company/profile/create', [App\Http\Controllers\Profile\CompanyProfileController::class, 'create'])->name('company.profile.create');
    Route::post('/company/profile', [App\Http\Controllers\Profile\CompanyProfileController::class, 'store'])->name('company.profile.store');
    Route::get('/company/profile/edit', [App\Http\Controllers\Profile\CompanyProfileController::class, 'edit'])->name('company.profile.edit');
    Route::put('/company/profile', [App\Http\Controllers\Profile\CompanyProfileController::class, 'update'])->name('company.profile.update');
});

// Job Post Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/job-posts/create', [App\Http\Controllers\JobPostController::class, 'create'])->name('job-posts.create');
    Route::post('/job-posts', [App\Http\Controllers\JobPostController::class, 'store'])->name('job-posts.store');
});

// Job Creation Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/jobs/create', [App\Http\Controllers\JobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [App\Http\Controllers\JobController::class, 'store'])->name('jobs.store');
});

// Job Listings Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/job-listings', [App\Http\Controllers\JobListingController::class, 'index'])->name('job-listings.index');
    Route::get('/job-listings/{jobListing}', [App\Http\Controllers\JobListingController::class, 'show'])->name('job-listings.show');
    Route::get('/job-listings/{jobListing}/apply', [App\Http\Controllers\JobListingController::class, 'apply'])->name('job-listings.apply');
    Route::post('/job-listings/{jobListing}/apply', [App\Http\Controllers\JobListingController::class, 'apply'])->name('job-listings.apply');
});

// Company-specific Job Listings Routes
Route::middleware(['auth', \App\Http\Middleware\CompanyProfileMiddleware::class])->group(function () {
    Route::get('/job-listings/create', [App\Http\Controllers\JobListingController::class, 'create'])->name('job-listings.create');
    Route::post('/job-listings', [App\Http\Controllers\JobListingController::class, 'store'])->name('job-listings.store');
    Route::get('/job-listings/{jobListing}/edit', [App\Http\Controllers\JobListingController::class, 'edit'])->name('job-listings.edit');
    Route::put('/job-listings/{jobListing}', [App\Http\Controllers\JobListingController::class, 'update'])->name('job-listings.update');
});

require __DIR__.'/auth.php';
