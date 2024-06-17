<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AllLocationsController extends Controller
{
    public function show()
    {
        $user_data = Auth::user();
        
        $location_list = Location::orderBy('display_name')->get();

        return view('all_locations', ['location_list' => $location_list]);
    }
}