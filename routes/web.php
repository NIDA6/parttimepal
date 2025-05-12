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
    Route::get('/jobseeker/profile/create', [JobseekerProfileController::class, 'create'])->name('jobseeker.profile.create');
    Route::post('/jobseeker/profile', [JobseekerProfileController::class, 'store'])->name('jobseeker.profile.store');
    Route::get('/jobseeker/profile/edit', [JobseekerProfileController::class, 'edit'])->name('jobseeker.profile.edit');
    Route::put('/jobseeker/profile', [JobseekerProfileController::class, 'update'])->name('jobseeker.profile.update');

    Route::get('/company/profile/create', [CompanyProfileController::class, 'create'])->name('company.profile.create');
    Route::post('/company/profile', [CompanyProfileController::class, 'store'])->name('company.profile.store');
    Route::get('/company/profile/edit', [CompanyProfileController::class, 'edit'])->name('company.profile.edit');
    Route::put('/company/profile', [CompanyProfileController::class, 'update'])->name('company.profile.update');
});

// Company-specific Job Listings Routes - These must come BEFORE the general job listings routes
Route::middleware(['auth', \App\Http\Middleware\CompanyProfileMiddleware::class])->group(function () {
    Route::get('/job-listings/create', [JobListingController::class, 'create'])->name('job-listings.create');
    Route::post('/job-listings', [JobListingController::class, 'store'])->name('job-listings.store');
    Route::get('/job-listings/{jobListing}/edit', [JobListingController::class, 'edit'])->name('job-listings.edit');
    Route::put('/job-listings/{jobListing}', [JobListingController::class, 'update'])->name('job-listings.update');
});

// General Job Listings Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/job-listings', [JobListingController::class, 'index'])->name('job-listings.index');
    Route::get('/job-listings/{jobListing}', [JobListingController::class, 'show'])->name('job-listings.show');
    Route::get('/job-listings/{jobListing}/apply', [JobListingController::class, 'apply'])->name('job-listings.apply');
    Route::post('/job-listings/{jobListing}/apply', [JobListingController::class, 'apply'])->name('job-listings.apply');
});

// Applications Routes
Route::middleware(['auth', 'company.profile'])->group(function () {
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
    Route::put('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.update-status');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Company Dashboard Routes
    Route::get('/company/dashboard', function () {
        return view('dashboard.companydashboard');
    })->name('company.dashboard');

    // Applications Routes
    Route::get('/applications', function () {
        $dummyApplications = [
            ['id' => 1, 'job_title' => 'Web Developer', 'applicant' => 'John Doe', 'status' => 'Pending', 'applied_at' => '2024-03-15'],
            ['id' => 2, 'job_title' => 'UI Designer', 'applicant' => 'Jane Smith', 'status' => 'Reviewed', 'applied_at' => '2024-03-14'],
            ['id' => 3, 'job_title' => 'Marketing Intern', 'applicant' => 'Mike Johnson', 'status' => 'Pending', 'applied_at' => '2024-03-13'],
        ];
        return view('applications.index', ['applications' => $dummyApplications]);
    })->name('applications.index');

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
    Route::get('/reviews', function () {
        $dummyReviews = [
            ['id' => 1, 'reviewer' => 'Alice Brown', 'rating' => 5, 'comment' => 'Great company to work with!', 'created_at' => '2024-03-15'],
            ['id' => 2, 'reviewer' => 'Bob Wilson', 'rating' => 4, 'comment' => 'Good experience overall', 'created_at' => '2024-03-14'],
            ['id' => 3, 'reviewer' => 'Carol Davis', 'rating' => 5, 'comment' => 'Excellent work environment', 'created_at' => '2024-03-13'],
        ];
        return view('reviews.index', ['reviews' => $dummyReviews]);
    })->name('reviews.index');
});

require __DIR__.'/auth.php';
