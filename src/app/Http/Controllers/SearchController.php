<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function show()
    {
        $asset_data = DB::select('SELECT * FROM assets');
        $assets = [];
        foreach ($asset_data as $asset) {
            $matching_site = DB::table('locations')->where('id', $asset->site)->first();
            $assets[] = [
                'model' => $asset->model,
                'site_name' => $matching_site->display_name
            ];
        }
        return view('search', ['assets' => $assets]);
    }
}