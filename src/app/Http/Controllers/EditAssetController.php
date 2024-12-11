<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Asset;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EditAssetController extends Controller
{
    public function show(Request $request)
    {
        $asset_id = $request->asset;
        $asset = Asset::where('id', $asset_id)->get()->first();
        return view('view_asset', ['asset' => $asset]);
    }
}