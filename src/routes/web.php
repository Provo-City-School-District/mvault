<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', [App\Http\Controllers\LoginController::class, 'show'])->name('login');

Route::get('/google/redirect', [App\Http\Controllers\GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [App\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('/logout', [App\Http\Controllers\LogoutController::class, 'logout']);

Route::get('/dashboard', function() {
	$data = DB::select('SELECT ip_address FROM sessions WHERE id = ?', [Session::getId()]);
	return view('dashboard', ['data' => $data]);
})->middleware('auth');
