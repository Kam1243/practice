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

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ShortUrlController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class,'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class,'login'])->middleware('guest');
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth')->name('logout');

Route::get('/dashboard', [DashboardController::class,'index'])->middleware('auth');

Route::get('/invitations/create', [InvitationController::class,'create'])->name('invitations.create');
Route::post('/invitations', [InvitationController::class,'store'])->name('invitations.store');
Route::get('/invitation/accept/{token}', [InvitationController::class,'accept'])->name('invitations.accept');
Route::post('/invitation/accept/{token}', [InvitationController::class,'processAccept'])->name('invitations.processAccept');

Route::get('/urls', [ShortUrlController::class,'index'])->name('urls.index');
Route::get('/urls/create', [ShortUrlController::class,'create'])->name('urls.create');
Route::post('/urls', [ShortUrlController::class,'store'])->name('urls.store');

Route::get('/s/{code}', [ShortUrlController::class,'resolve'])->name('short.resolve');
