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
Route::get('/meet-me/{meeting_id}', [App\Http\Controllers\JoinController::class, 'index'])->name('join');
Route::get('/join/{meeting_id?}', [App\Http\Controllers\JoinController::class, 'index'])->name('join');
Route::get('/room/{room_id}', [App\Http\Controllers\JoinController::class, 'index'])->name('room');

Route::get('/expert', [App\Http\Controllers\admin\UsersController::class, 'expert_view_frontend'])->name('expert');
Route::get('/expert/view/{id}', [App\Http\Controllers\admin\UsersController::class, 'expert_singleUser_frontend'])->name('expert/view');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/google_signout', [App\Http\Controllers\DashboardController::class, 'google_signout'])->name('google_signout');
Route::match(array('GET','POST'),'/dashboard/settings', [App\Http\Controllers\DashboardController::class, 'settings'])->name('settings');

Route::get('/meetings/{meeting_id?}', [App\Http\Controllers\DashboardController::class, 'meetings'])->name('meetings');
Route::post('/meeting/delete/{meeting_id}', [App\Http\Controllers\DashboardController::class, 'delete_meeting'])->name('delete_meetings');
Route::match(array('GET','POST'),'/schedule', 'App\Http\Controllers\DashboardController@schedule')->name('schedule');
Route::match(array('GET','POST'), '/meeting/edit/{meeting_id}', [App\Http\Controllers\DashboardController::class, 'editMeeting'])->name('edit_meeting');

Route::get('/getmeetingdeail', [App\Http\Controllers\MeetingsController::class, 'getmeetingdetail'])->name('meetings');
Route::get('/gettoken', [App\Http\Controllers\MeetingsController::class, 'generateToken'])->name('token');
Route::post('/endmeeting', [App\Http\Controllers\MeetingsController::class, 'endMeeting'])->name('end_meetings');

Route::match(['GET', 'POST'], '/payment/meeting/{meeting_id}', [App\Http\Controllers\PaymentsController::class, 'meeting'])->name('meeting_payment');

/* admin routs */
Route::group(['middleware'  => ['auth','admin']], function() {
	// you can use "/admin" instead of "/dashboard"
	Route::get('/admin/dashboard', 'App\Http\Controllers\admin\DashboardController@index');
        Route::get('/admin', 'App\Http\Controllers\admin\DashboardController@index');
        Route::match(['GET', 'POST'],'/admin/settings', 'App\Http\Controllers\Admin\SettingsController@index');
        Route::match(['GET', 'POST'], 'admin/settings/apisettings', 'App\Http\Controllers\Admin\SettingsController@api_settings');
        
	Route::get('/admin/meetings', 'App\Http\Controllers\Admin\MeetingsController@index');
        
        Route::get('/admin/users', 'App\Http\Controllers\Admin\UsersController@index');
        Route::post('/admin/users/delete/{user_id}', 'App\Http\Controllers\Admin\UsersController@delete');
        Route::match(['GET', 'POST'], '/admin/users/add', 'App\Http\Controllers\Admin\UsersController@add');
        Route::get('/admin/expert/create', 'App\Http\Controllers\admin\UsersController@expert');
        Route::post('/admin/expert/add', 'App\Http\Controllers\admin\UsersController@create_expert');
        Route::get('/admin/expert', 'App\Http\Controllers\admin\UsersController@expert_view');
        Route::get('/admin/expert/delete/{id}', 'App\Http\Controllers\admin\UsersController@destroy');

        
});

