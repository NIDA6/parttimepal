<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Profile\CompanyProfileController;
use App\Http\Controllers\Profile\JobseekerProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BrowseController;
use App\Http\Controllers\ReviewController;

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
    Route::get('/jobseeker/profile/create', [JobseekerProfileController::class, 'create'])->name('jobseeker.profile.create');
    Route::post('/jobseeker/profile', [JobseekerProfileController::class, 'store'])->name('jobseeker.profile.store');
    Route::get('/jobseeker/profile/edit', [JobseekerProfileController::class, 'edit'])->name('jobseeker.profile.edit');
    Route::put('/jobseeker/profile', [JobseekerProfileController::class, 'update'])->name('jobseeker.profile.update');

    Route::get('/company/profile/create', [CompanyProfileController::class, 'create'])->name('company.profile.create');
    Route::post('/company/profile', [CompanyProfileController::class, 'store'])->name('company.profile.store');
    Route::get('/company/profile/edit', [CompanyProfileController::class, 'edit'])->name('company.profile.edit');
    Route::put('/company/profile', [CompanyProfileController::class, 'update'])->name('company.profile.update');
    Route::get('/company/profile/{companyProfile}', [CompanyProfileController::class, 'show'])->name('company-profiles.show');
    Route::get('/jobseeker/profile/{jobseekerProfile}', [JobseekerProfileController::class, 'show'])->name('jobseeker-profiles.show');
});

// General Job Listings Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/job-listings', [JobListingController::class, 'index'])->name('job-listings.index');
    Route::get('/job-listings/{jobListing}', [JobListingController::class, 'show'])->name('job-listings.show');
});

// Job Application Routes - Separate from company routes
Route::middleware(['auth'])->group(function () {
    Route::get('/job-listings/{jobListing}/apply', [JobListingController::class, 'apply'])->name('job-listings.apply.form');
    Route::post('/job-listings/{jobListing}/apply', [JobListingController::class, 'apply'])->name('job-listings.apply.submit');
});

// Company-specific Job Listings Routes
Route::middleware(['auth', 'company.profile'])->group(function () {
    Route::get('/job-listings/create', [JobListingController::class, 'create'])->name('job-listings.create');
    Route::post('/job-listings', [JobListingController::class, 'store'])->name('job-listings.store');
    Route::get('/job-listings/{jobListing}/edit', [JobListingController::class, 'edit'])->name('job-listings.edit');
    Route::put('/job-listings/{jobListing}', [JobListingController::class, 'update'])->name('job-listings.update');
    Route::delete('/job-listings/{jobListing}', [JobListingController::class, 'destroy'])->name('job-listings.destroy');
    Route::get('/job-listings/{jobListing}/applications', [JobListingController::class, 'applications'])->name('job-listings.applications');
});

// Applications Routes
Route::middleware(['auth', 'company.profile'])->group(function () {
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
    Route::put('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.update-status');
});

// Browse routes
Route::get('/browse', [BrowseController::class, 'index'])->name('browse.index');

Route::middleware(['auth', 'verified'])->group(function () {
    // Company Dashboard Routes
    Route::get('/company/dashboard', function () {
        return view('dashboard.companydashboard');
    })->name('company.dashboard');

    // Notifications Routes
    Route::get('/notifications', function () {
        $dummyNotifications = [
            ['id' => 1, 'title' => 'New Application', 'message' => 'John Doe applied for Web Developer position', 'created_at' => '2024-03-15 10:30'],
            ['id' => 2, 'title' => 'Profile Update', 'message' => 'Your company profile was updated successfully', 'created_at' => '2024-03-14 15:45'],
            ['id' => 3, 'title' => 'New Review', 'message' => 'You received a new 5-star review', 'created_at' => '2024-03-13 09:15'],
        ];
        return view('notifications.index', ['notifications' => $dummyNotifications]);
    })->name('notifications.index');

    // Reviews Routes
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

    // Browse detail routes
    Route::get('/browse/company/{id}', [BrowseController::class, 'showCompany'])->name('browse.company');
    Route::get('/browse/jobseeker/{id}', [BrowseController::class, 'showJobseeker'])->name('browse.jobseeker');
});

// Admin Routes
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/jobseekers', [App\Http\Controllers\Admin\UserController::class, 'jobseekers'])->name('admin.jobseekers');
    Route::get('/admin/jobseekers/{user}', [App\Http\Controllers\Admin\UserController::class, 'showJobseeker'])->name('admin.jobseekers.show');
    Route::delete('/admin/jobseekers/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroyJobseeker'])->name('admin.jobseekers.destroy');
    Route::get('/admin/companies', [App\Http\Controllers\Admin\UserController::class, 'companies'])->name('admin.companies');
    Route::get('/admin/companies/{user}', [App\Http\Controllers\Admin\UserController::class, 'showCompany'])->name('admin.companies.show');
    Route::delete('/admin/companies/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroyCompany'])->name('admin.companies.destroy');
    Route::get('/admin/admins', [App\Http\Controllers\Admin\UserController::class, 'admins'])->name('admin.admins');
});

// Notification routes
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});

// Review routes
Route::middleware(['auth'])->group(function () {
    Route::post('/company-profile/{companyProfile}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

require __DIR__.'/auth.php';
