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

Auth::routes(['register' => false, 'login' => false]);

Route::get('signin', 'App\Http\Controllers\Auth\LoginController@showLoginForm');
Route::post('signin', 'App\Http\Controllers\Auth\LoginController@login')->name('login');
Route::get('/', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm');
Route::post('/', 'App\Http\Controllers\Auth\RegisterController@register')->name('register');
Route::get('/chat', [App\Http\Controllers\ChatsController::class, 'index']);
Route::get('/messages', [App\Http\Controllers\ChatsController::class, 'fetchMessages']);
Route::post('/messages', [App\Http\Controllers\ChatsController::class, 'sendMessage']);
