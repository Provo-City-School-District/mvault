<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Asset;


use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SearchController extends Controller
{
    public function show()
    {
        return view('search');
    }

    const VALID_SEARCH_BY = ["barcode_serial", "barcode", "serial", "location"];

    public function handleForm(Request $request) {
        $search_by = $request->get("search_by");
        if (!in_array($search_by, SearchController::VALID_SEARCH_BY)) {
            return back()->withErrors("Invalid search_by field!");
        }

        $query = $request->get("search_query");
        
        switch ($search_by) {
            case "barcode_serial":
                $assets = Asset::where('barcode', 'LIKE', "%$query%")
                                        ->orWhere('serial', 'LIKE', "%$query%")
                                        ->get();
            break;
            case "barcode":
                $assets = Asset::where('barcode', 'LIKE', "%$query%")->get();
            break;
            case "serial":
                $assets = Asset::where('serial', 'LIKE', "%$query%")->get();
            break;
            case "location":
                $location_id = Location::where('display_name', 'LIKE', "%$query%")->first()->id;

                $assets = Asset::where('site', $location_id)->get();
            break;
        }

        foreach ($assets as $asset) {
            $site_name = Location::where('id', $asset->site)->first()->display_name;
            $asset->location_str = "$site_name | $asset->room";
        }

        return view('search_results', ['assets' => $assets]);
    }
}