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
        $asset = Asset::where('id', $asset_id)->first();
        $sites = Location::all();
        return view('edit_asset', ['asset' => $asset, 'sites' => $sites]);
    }

    public function handleForm(Request $request)
    {
        $asset = Asset::where('id', $request->id)->first();
        $asset->serial = $request->get("serial");
        $asset->barcode = $request->get("barcode");

        $asset->company = $request->get("company");
        $asset->model = $request->get("model");

        $site_number = $request->get("site_number");
        $asset->site = Location::where('site_number', $site_number)->first()->id;
        $asset->room = $request->get("room");
        $asset->program = $request->get("program");
        $asset->category = $request->get("category");
        $asset->purchase_date = $request->get("purchase_date");
        $asset->expected_lifespan = $request->get("expected_lifespan");

        $asset->notes = $request->get("notes");
        $asset->save();

        return redirect()->back()->with('status', 'Asset has been successfully updated');   
    }
}