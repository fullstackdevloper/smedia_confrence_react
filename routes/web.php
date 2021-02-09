<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/join/{meeting_id?}', [App\Http\Controllers\JoinController::class, 'index'])->name('join');
Route::get('/room/{room_id}', [App\Http\Controllers\JoinController::class, 'index'])->name('room');
Route::get('/meet-me/{meeting_id}', [App\Http\Controllers\JoinController::class, 'meet_me'])->name('meet-me');

Route::get('/token', [App\Http\Controllers\TwilioController::class, 'generatetoken'])->name('token');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/google_signout', [App\Http\Controllers\DashboardController::class, 'google_signout'])->name('google_signout');
Route::get('/settings', [App\Http\Controllers\DashboardController::class, 'settings'])->name('settinga');
Route::get('/meetings', [App\Http\Controllers\DashboardController::class, 'meetings'])->name('meetings');
//Route::get('/schedule', [App\Http\Controllers\DashboardController::class, 'schedule'])->name('schedule');
Route::match(array('GET','POST'),'/schedule', 'App\Http\Controllers\DashboardController@schedule')->name('schedule');
