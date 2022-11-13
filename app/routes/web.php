<?php

use App\Models\User;
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

Auth::routes(['login' => false, 'register' => false]);

Route::get('/', function () {
    $userCount = User::count();
    return view('welcome',  compact('userCount'));
});
Route::get('/', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm');
Route::post('/', 'App\Http\Controllers\Auth\RegisterController@register')->name('register');
Route::get('/chat', [App\Http\Controllers\ChatsController::class, 'index']);
Route::get('/messages', [App\Http\Controllers\ChatsController::class, 'fetchMessages']);
Route::post('/messages', [App\Http\Controllers\ChatsController::class, 'sendMessage']);
