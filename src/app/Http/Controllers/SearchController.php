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
        $assets_parsed = [];
        
        foreach ($assets as $asset) {
            $matching_site = DB::table('locations')->where('id', $asset->site)->first();
            $assets_parsed[] = [
                'model' => $asset->model,
                'site_name' => $matching_site->display_name
            ];
        }
        return view('search', ['assets' => $assets_parsed]);
    }
}