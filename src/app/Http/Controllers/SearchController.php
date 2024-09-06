<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
}