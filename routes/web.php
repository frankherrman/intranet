<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\HourController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\SlaContractController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


/**
  * All ADMIN routes
  */
Route::middleware(['auth:sanctum', 'verified'])->middleware('can:isAdmin')->group(function() {
    Route::resource('servers', ServerController::class);
});

/**
  * All MANAGE_CLIENT routes
  */
Route::middleware(['auth:sanctum', 'verified'])->middleware('can:manageClients')->group(function() {
  Route::resource('clients', ClientController::class);
});

/**
  * All MANAGE_SLA routes
  */
Route::middleware(['auth:sanctum', 'verified'])->middleware('can:manageSla')->group(function() {
  Route::resource('sla', SlaContractController::class);
});

/**
  * All MANAGE_PROJECTS routes
  */
Route::middleware(['auth:sanctum', 'verified'])->middleware('can:manageProjects')->group(function() {
    Route::resource('projects', ProjectController::class);
});

/**
  * All MANAGE_ACTIVITIES routes
  */
Route::middleware(['auth:sanctum', 'verified'])->middleware('can:manageActivities')->group(function() {
    Route::resource('activities', ActivityController::class);
});

/**
  * All TIMEMANAGEMENT routes
  */
Route::middleware(['auth:sanctum', 'verified'])->middleware('can:accessTimemanagement')->group(function() {
  Route::get('timesheet/{date?}', [HourController::class, 'entry'])->name('timesheet.entry');
});

/**
  * All REPORTING routes
  */
Route::middleware(['auth:sanctum', 'verified'])->middleware('can:viewReporting')->group(function() {
  Route::get('reporting', 'ReportingController@view')->name('reporting.index');
});

/**
  * All HR routes
  */
Route::middleware(['auth:sanctum', 'verified'])->middleware('can:isHr')->group(function() {
  Route::resource('users', UserController::class);
});

/**
  * All INVOICING routes
  */
  Route::middleware(['auth:sanctum', 'verified'])->middleware('can:accessInvoicing')->group(function() {
    Route::get('invoicing', 'InvoicingController@generate')->name('invoicing.generate');
});