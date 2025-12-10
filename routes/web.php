<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\AddGigController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ClientJobController;
use App\Http\Controllers\ClientProfileController;
use App\Http\Controllers\FreelancerProfileController;
use App\Http\Controllers\GigBrowseController;
use App\Http\Controllers\OrderController;


/*
|--------------------------------------------------------------------------
| Public Pages (No Login Required)
|--------------------------------------------------------------------------
*/

// Home / Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Account type selection (Client or Freelancer)
Route::get('/account_type', function () {
    return view('account_type');
});


/*
|--------------------------------------------------------------------------
| Login Routes (Used by BOTH Client & Freelancer)
|--------------------------------------------------------------------------
*/

// Show login page
Route::get('/login', [LoginController::class, 'showLoginForm'])
     ->name('login');

// Handle login form submit
Route::post('/login', [LoginController::class, 'login'])
     ->name('login.post');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
     ->name('logout');


/*
|--------------------------------------------------------------------------
| Client Registration Routes
|--------------------------------------------------------------------------
*/

// Show client sign-up form
Route::get('/client_ac', [ClientController::class, 'showRegisterForm'])
     ->name('client.register.form');

// Handle client sign-up
Route::post('/client_ac', [ClientController::class, 'clientregister'])
     ->name('client.signup');


/*
|--------------------------------------------------------------------------
| Freelancer Registration Routes
|--------------------------------------------------------------------------
*/

// Show freelancer sign-up form
Route::get('/freelancer_ac', function () {
    return view('freelancer_ac');   // OR create showForm in controller
})->name('freelancer.register.form');

// Handle freelancer sign-up form submit
Route::post('/freelancer_ac', [FreelancerController::class, 'freelancerregister'])
     ->name('freelancer.signup');


/*
|--------------------------------------------------------------------------
| Dashboards (Protected Routes)
|--------------------------------------------------------------------------
|
| These routes require login. Only the correct guard can access them.
|
*/

// Client dashboard
Route::get('/client/dashboard', function () {
    return view('welcome'); // You can replace with your dashboard view
})->name('client.dashboard')->middleware('auth:client');

// Freelancer dashboard
Route::get('/freelancer/dashboard', function () {
    return view('welcome');
})->name('freelancer.dashboard')->middleware('auth:freelancer');


// Job Posting clientAuth->kernel.php

Route::middleware(['clientAuth'])->group(function () {
    Route::get('/post', [JobPostingController::class, 'showCategories']);
    Route::post('/post', [JobPostingController::class, 'saveJob'])->name('jobpost');
});

Route::get('/dashboard',function(){
    return view('client.dashboard');
});

Route::get('/fdashboard',[AddGigController::class, 'show'])->name('gig.show');
Route::get('/fdashboard', [AddGigController::class, 'index'])->name('gigs.index');

Route::middleware(['freelancerAuth'])->group(function () {
    Route::get('/gig', [AddGigController::class, 'getallskills']);
    Route::post('/gig', [AddGigController::class,'store'])->name('gig.store');
    Route::get('/gig/{id}/edit', [AddGigController::class, 'edit'])->name('gig.edit');
    Route::put('/gig/{id}', [AddGigController::class, 'update'])->name('gig.update');
    Route::delete('/gig/{id}', [AddGigController::class, 'destroy'])->name('gig.destroy');
    
    // Job Application Routes for Freelancers
    Route::get('/jobs/browse', [App\Http\Controllers\JobApplicationController::class, 'browse'])->name('jobs.browse');
    Route::post('/jobs/{id}/apply', [App\Http\Controllers\JobApplicationController::class, 'apply'])->name('jobs.apply');
    Route::get('/my-applications', [App\Http\Controllers\JobApplicationController::class, 'myApplications'])->name('applications.my');
    Route::delete('/applications/{id}/withdraw', [App\Http\Controllers\JobApplicationController::class, 'withdraw'])->name('applications.withdraw');
});

Route::get('/gig/{id}', [AddGigController::class, 'details'])->name('gig.details');

//profile
Route::get('/profile',function(){
    return view('profile');
});


// Client Google Login
Route::get('/auth/google/client', [GoogleController::class, 'redirectClient']);
Route::get('/auth/google/client/callback', [GoogleController::class, 'handleGoogleClient']);

// Freelancer Google Login
Route::get('/auth/google/freelancer', [GoogleController::class, 'redirectFreelancer']);
Route::get('/auth/google/freelancer/callback', [GoogleController::class, 'handleGoogleFreelancer']);


//Job Details
Route::get('/dashboard', [ClientJobController::class, 'index'])->name('client.jobboard');
Route::get('/client/job/{id}', [ClientJobController::class, 'showdetails'])->name('client.job.show');

Route::delete('/client/job/{id}', [JobPostingController::class, 'delete'])
        ->name('client.job.delete');

Route::get('/client/job/{id}/edit', [JobPostingController::class, 'edit'])
    ->name('client.job.edit')
    ->middleware('clientAuth');

Route::put('/client/job/{id}', [JobPostingController::class, 'update'])
    ->name('client.job.update')
    ->middleware('clientAuth');

//Update Profile
// CLIENT
Route::get('/client/profile', [ClientProfileController::class, 'edit'])->name('client.profile');
Route::post('/client/profile', [ClientProfileController::class, 'update'])->name('client.profile.update');

// FREELANCER
Route::get('/freelancer/profile', [FreelancerProfileController::class, 'edit'])->name('freelancer.profile');
Route::post('/freelancer/profile', [FreelancerProfileController::class, 'update'])->name('freelancer.profile.update');

// Job Application Routes for Clients
Route::middleware(['clientAuth'])->group(function () {
    Route::get('/jobs/{id}/applications', [App\Http\Controllers\JobApplicationController::class, 'viewApplications'])->name('job.applications');
    Route::post('/applications/{id}/accept', [App\Http\Controllers\JobApplicationController::class, 'accept'])->name('application.accept');
    Route::post('/applications/{id}/reject', [App\Http\Controllers\JobApplicationController::class, 'reject'])->name('application.reject');
    
    // Gig Browsing and Ordering Routes for Clients
    Route::get('/gigs/browse', [GigBrowseController::class, 'index'])->name('gigs.browse');
    Route::get('/gigs/{id}', [GigBrowseController::class, 'show'])->name('gigs.show');
    Route::post('/gigs/{id}/order', [OrderController::class, 'store'])->name('order.place');
    Route::get('/my-orders', [OrderController::class, 'clientOrders'])->name('client.orders');
    Route::post('/orders/{id}/accept-delivery', [OrderController::class, 'acceptDelivery'])->name('order.accept.delivery');
    Route::post('/orders/{id}/request-revision', [OrderController::class, 'requestRevision'])->name('order.request.revision');
    
    // Job Application Work Review
    Route::post('/job-applications/{id}/accept-delivery', [App\Http\Controllers\JobApplicationController::class, 'acceptDelivery'])->name('job.accept.delivery');
    Route::post('/job-applications/{id}/request-revision', [App\Http\Controllers\JobApplicationController::class, 'requestRevision'])->name('job.request.revision');
});

// Order Management Routes for Freelancers
Route::middleware(['freelancerAuth'])->group(function () {
    Route::get('/my-gig-orders', [OrderController::class, 'freelancerOrders'])->name('freelancer.orders');
    Route::post('/orders/{id}/accept', [OrderController::class, 'accept'])->name('order.accept');
    Route::post('/orders/{id}/reject', [OrderController::class, 'reject'])->name('order.reject');
    Route::post('/orders/{id}/deliver', [OrderController::class, 'submitDelivery'])->name('order.deliver');
    
    // Job Application Work Submission
    Route::post('/job-applications/{id}/submit-work', [App\Http\Controllers\JobApplicationController::class, 'submitWork'])->name('job.submit.work');
});

// Notification Routes (for both clients and freelancers)
Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
