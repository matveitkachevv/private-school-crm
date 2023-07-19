<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Event;
use App\Http\Controllers\Group;
use App\Http\Controllers\User;
use App\Http\Controllers\Cabinet;
use App\Http\Controllers\Subscribe;
use App\Http\Controllers\Visit;

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

Route::get('/events/', [Event::class, 'getAll']);
Route::post('/event/', [Event::class, 'create']);
Route::get('/event/{eventId}', [Event::class, 'get'])->where('eventId', '[0-9]+');
Route::delete('/event/{eventId}', [Event::class, 'delete'])->where('eventId', '[0-9]+');

Route::get('/groups/', [Group::class, 'getAll']);
Route::post('/group/', [Group::class, 'create']);
Route::get('/group/{groupId}/', [Group::class, 'get'])->where('groupId', '[0-9]+');
Route::delete('/group/{groupId}', [Group::class, 'delete'])->where('groupId', '[0-9]+');

Route::post('/user/', [User::class, 'create']);
Route::get('/users/', [User::class, 'getAll']);
Route::get('/user/{userId}/', [User::class, 'get'])->where('userId', '[0-9]+');
Route::get('/user/{userId}/subscribes/', [User::class, 'getSubscribes'])->where('userId', '[0-9]+');
Route::put('/user/{userId}/group/change/', [User::class, 'changeGroup'])->where('userId', '[0-9]+');
Route::delete('/user/{userId}', [User::class, 'delete'])->where('userId', '[0-9]+');

Route::get('/cabinets/', [Cabinet::class, 'get']);
Route::post('/cabinet/', [Cabinet::class, 'create']);
Route::delete('/cabinet/{cabinetId}', [Cabinet::class, 'delete'])->where('cabinetId', '[0-9]+');


Route::put('/visit/{visitId}/', [Visit::class, 'change'])->where('visitId', '[0-9]+');


Route::post('/subscribe/', [Subscribe::class, 'create']);
Route::put('/subscribe/{subscribeId}/payment/', [Subscribe::class, 'paymentChange'])->where('subscribeId', '[0-9]+');
Route::delete('/subscribe/{subscribeId}', [Subscribe::class, 'delete'])->where('subscribeId', '[0-9]+');

