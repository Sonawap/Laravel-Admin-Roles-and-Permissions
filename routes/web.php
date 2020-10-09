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

Route::get('/notifications', function () {
    return view('pages.notifications');
})->name('notifications');

Route::get('/user/mark-all-read/', function(){
    auth()->user()->unreadNotifications->markAsRead();
    return response()->json(['message'=>'marked as read'],200);
});

Route::get('/admin/auth/notifications', 'UserController@getNotifications');

Route::resource('profile', 'ProfileController');

Route::group(['middleware' => ['role_or_permission:admin|edit users']], function () {

    Route::resource('permission', 'PermissionController');

    Route::resource('role', 'RoleController');

    Route::resource('user', 'UserController');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/password/change', 'UserController@getPassword')->name('password.change');

Route::post('/password/change', 'UserController@postPassword')->name('password.change');




Route::get('/getPermission', 'PermissionController@getAllPermissions');

Route::get('getRole/{id}', 'RoleController@getAllRole');

Route::post('/saveRole', 'RoleController@store');

Route::put('/editRole/{id}', 'RoleController@update');

Route::get('/get/user', 'UserController@getIndex');

Route::get('/get/user/customer', 'UserController@getCustomer');

Route::get('/get/user/admin', 'UserController@getAdmin');

Route::get('/get/user/user', 'UserController@getUser');

Route::get('/get/user/search/{search}', 'UserController@search');




Route::get('/photo', 'UserController@photo')->name('user.photo');

Route::post('/uploadProfilePhoto', 'UserController@UploadImage');
