<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\AddGigController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ClientJobController;


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

