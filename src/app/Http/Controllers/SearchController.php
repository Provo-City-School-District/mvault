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
        return view('search', ['search_by_eol' => false]);
    }

    public function show_eol()
    {
        return view('search', ['search_by_eol' => true]);
    }

    public function handleForm(Request $request) {
        $request->validate([
            'search_by' => 'required|in:name,barcode_serial,barcode,serial,location',
            'search_query' => 'required|string',
        ]);

        $search_by = $request->get("search_by");
        $query = $request->get("search_query");

        if ($request->has('is_eol')) {
            $eol_search = true;
        } else {
            $eol_search = false;
        }
        
        switch ($search_by) {
            case "name":
                $assets = Asset::where('name', 'LIKE', "%$query%")
                    ->where('eol', $eol_search)
                    ->get();
            break;
            case "barcode_serial":
                $assets = Asset::where('barcode', 'LIKE', "%$query%")
                                        ->orWhere('serial', 'LIKE', "%$query%")
                                        ->where('eol', $eol_search)
                                        ->get();
            break;
            case "barcode":
                $assets = Asset::where('barcode', 'LIKE', "%$query%")
                    ->where('eol', $eol_search)
                    ->get();
            break;
            case "serial":
                $assets = Asset::where('serial', 'LIKE', "%$query%")
                    -where('eol', $eol_search)
                    ->get();
            break;
            case "location":
                $location_id = Location::where('display_name', 'LIKE', "%$query%")->first()->id;

                $assets = Asset::where('site', $location_id)
                    ->where('eol', $eol_search)
                    ->get();
            break;
        }

        foreach ($assets as $asset) {
            $site_name = Location::where('id', $asset->site)->first()->display_name;
            $asset->location_str = "$site_name | $asset->room";
        }

        return view('search_results', ['assets' => $assets]);
    }
}