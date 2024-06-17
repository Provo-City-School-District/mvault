<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Asset;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LocationAssetsController extends Controller
{
    public function show(Request $request)
    {
        $location_number = $request->location;
        $location_data = Location::where('site_number', $location_number)->first();

        $user_data = Auth::user();
        
        $location_name = $location_data["display_name"];

        $assets = Asset::where('site', $location_data["id"])->get();

        return view('location_assets', ['location_name' => $location_name, 'assets' => $assets]);
    }
}