<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', [App\Http\Controllers\LoginController::class, 'show'])->name('login');
Route::get('/logout', [App\Http\Controllers\LogoutController::class, 'logout'])->name('logout');

Route::get('/google/redirect', [App\Http\Controllers\GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [App\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name("profile");
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'show'])->name("admin");

    Route::get('/asset_companies', [App\Http\Controllers\AssetCompaniesController::class, 'show'])->name("asset_companies");

    Route::get('/create_asset', [App\Http\Controllers\CreateAssetController::class, 'show'])->name("create_asset");
    Route::post('/create_asset', [App\Http\Controllers\CreateAssetController::class, 'handleForm']);

    Route::get('/all_locations', [App\Http\Controllers\AllLocationsController::class, 'show'])->name("all_locations");

    Route::get('/edit_asset/{asset_id}', [App\Http\Controllers\EditAssetController::class, 'show'])->name("edit_asset");
    Route::get('/edit_asset_bc/{barcode}', [App\Http\Controllers\EditAssetController::class, 'show_barcode'])->name("edit_asset_barcode");
    Route::post('/update_asset', [App\Http\Controllers\EditAssetController::class, 'handleForm'])->name("update_asset");
    Route::post('/assets/{asset}/work-done', [App\Http\Controllers\WorkDoneController::class, 'store'])->name('work_done.store');

    Route::get('/location_assets/{location}', [App\Http\Controllers\LocationAssetsController::class, 'show'])->name("location_assets");

    Route::get('/search', [App\Http\Controllers\SearchController::class, 'show'])->name("search");
    Route::post('/search', [App\Http\Controllers\SearchController::class, 'handleForm'])->name("search.form");
});
