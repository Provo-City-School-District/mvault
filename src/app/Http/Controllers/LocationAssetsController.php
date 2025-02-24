<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\AssetCategory;
use App\Models\Asset;
use App\Models\AssetCompany;

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

        // Fetch all categories
        $categoryIds = $assets->pluck('category')->unique();
        $categories = AssetCategory::whereIn('id', $categoryIds)->get()->keyBy('id');

        // Fetch all companies in a single query
        $companyIds = $assets->pluck('company')->unique();
        $companies = AssetCompany::whereIn('id', $companyIds)->get()->keyBy('id');

        // Map categories to assets
        foreach ($assets as $asset) {
            $asset->category_name = $categories[$asset->category]->display_name ?? 'Unknown';
            $asset->company_name = $companies[$asset->company]->name ?? 'Unknown';
        }
        return view('location_assets', ['location_name' => $location_name, 'assets' => $assets]);
    }
}
