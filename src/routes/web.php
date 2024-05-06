<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', [App\Http\Controllers\LoginController::class, 'show'])->name('login');
Route::get('/logout', [App\Http\Controllers\LogoutController::class, 'logout'])->name('logout');

Route::get('/google/redirect', [App\Http\Controllers\GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [App\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

Route::group(['middleware' => 'auth'], function () {
	Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name("profile");
	Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'show']);
});
