<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\AssetCategory;
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
                
        $location_name = $location_data["display_name"];
        $assets = Asset::where('site', $location_data["id"])->get();

        foreach ($assets as $asset) { 
            $category = AssetCategory::where('id', $asset->category)->first();
            $asset->category_name = $category->display_name;
        }


        return view('location_assets', ['location_name' => $location_name, 'assets' => $assets]);
    }
}