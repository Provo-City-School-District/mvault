<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/db_test', function() {
	$data = DB::select('SELECT ip_address FROM sessions WHERE id = ?', [Session::getId()]);
	return view('db_test', ['data' => $data]);
});