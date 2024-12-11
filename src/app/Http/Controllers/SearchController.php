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
        $assets = Asset::all();
        
        foreach ($assets as $asset) {
            $matching_site = DB::table('locations')->where('id', $asset->site)->first();

            // site_name doesn't exist until this, but this seems 
            // like the cleanest way to get the data to the view
            $asset->site_name = $matching_site->display_name;
        }

        return view('search', ['assets' => $assets]);
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
                $results = Asset::where('barcode', 'LIKE', "%$query%")
                                        ->orWhere('serial', 'LIKE', "%$query%")
                                        ->get();
            break;
            case "barcode":
                $results = Asset::where('barcode', 'LIKE', "%$query%")->get();
            break;
            case "serial":
                $results = Asset::where('serial', 'LIKE', "%$query%")->get();
            break;
            case "location":
                $location_id = Location::where('display_name', 'LIKE', "%$query%")->first()->id;

                $results = Asset::where('site', $location_id)->get();
            break;
        }

        echo $results;
    }
}