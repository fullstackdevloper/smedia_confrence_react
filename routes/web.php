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
Route::get('/join', [App\Http\Controllers\JoinController::class, 'index'])->name('join');
Route::get('/room/{room_id}', [App\Http\Controllers\JoinController::class, 'index'])->name('join');
Route::get('/token', [App\Http\Controllers\TwilioController::class, 'generatetoken'])->name('token');
