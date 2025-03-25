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
    Route::get('/all_users', [App\Http\Controllers\AllUsersController::class, 'show'])->name("all_users");
    Route::get('/manage_user/{id}', [App\Http\Controllers\ManageUserController::class, 'show'])->name("manage_user");
    Route::post('/update_user', [App\Http\Controllers\ManageUserController::class, 'updateUser'])->name("update_user");

    Route::get('/create_asset', [App\Http\Controllers\CreateAssetController::class, 'show'])->name("create_asset");
    Route::post('/create_asset', [App\Http\Controllers\CreateAssetController::class, 'handleForm']);

    Route::get('/all_locations', [App\Http\Controllers\AllLocationsController::class, 'show'])->name("all_locations");

    Route::get('/edit_asset/{asset_id}', [App\Http\Controllers\EditAssetController::class, 'show'])->name("edit_asset");
    Route::get('/edit_asset_bc/{barcode}', [App\Http\Controllers\EditAssetController::class, 'show_barcode'])->name("edit_asset_barcode");
    Route::post('/eol_asset', [App\Http\Controllers\EditAssetController::class, 'handleEOLAsset'])->name("edit_asset.eol");
    Route::post('/undo_eol_asset', [App\Http\Controllers\EditAssetController::class, 'handleUndoEOLAsset'])->name("edit_asset.un-eol");
    Route::post('/update_asset', [App\Http\Controllers\EditAssetController::class, 'handleForm'])->name("update_asset");

    Route::post('/assets/{asset}/work-done', [App\Http\Controllers\WorkDoneController::class, 'store'])->name('work_done.store');

    Route::post('/maintenance/schedule/{asset}', [App\Http\Controllers\EditAssetController::class, 'scheduleMaintenance'])->name('maintenance.schedule');
    Route::delete('/maintenance/delete/{id}', [App\Http\Controllers\EditAssetController::class, 'deleteMaintenance'])->name('maintenance.delete');

    Route::get('/location_assets/{location}', [App\Http\Controllers\LocationAssetsController::class, 'show'])->name("location_assets");

    Route::get('/search', [App\Http\Controllers\SearchController::class, 'show'])->name("search");
    Route::get('/search_eol', [App\Http\Controllers\SearchController::class, 'show_eol'])->name("search_eol");
    Route::post('/search', [App\Http\Controllers\SearchController::class, 'handleForm'])->name("search.form");
});
