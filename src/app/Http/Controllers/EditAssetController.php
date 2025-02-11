<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Asset;
use App\Models\AssetCategory;

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
        $categories = AssetCategory::orderBy('display_name')->get();
        return view('edit_asset', ['asset' => $asset, 'sites' => $sites, 'categories' => $categories]);
    }

    public function handleForm(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'asset_name' => 'required',
            'serial' => 'required',
            'company' => 'required',
            'category' => 'required',
            'model' => 'required',
            'site_number' => 'required',
            'purchase_price' => 'required',
            'purchase_date' => 'required',
            'projected_eol_date' => 'required',
        ]);

        $asset = Asset::where('id', $request->id)->first();
        $asset->name = $request->get("asset_name");
        $asset->serial = $request->get("serial");
        $asset->barcode = $request->get("barcode");

        $asset->company = $request->get("company");
        $asset->model = $request->get("model");

        $site_number = $request->get("site_number");
        $asset->site = Location::where('site_number', $site_number)->first()->id;
        $asset->room = $request->get("room");
        $asset->category = $request->get("category");
        $asset->purchase_date = $request->get("purchase_date");
        $asset->purchase_price = $request->get("purchase_price");
        $asset->projected_eol_date = $request->get("projected_eol_date");
        $asset->description = $request->get("description");

        $asset->save();

        return redirect()->back()->with('status', 'Asset has been successfully updated');   
    }
}