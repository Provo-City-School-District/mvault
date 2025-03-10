<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Asset;
use App\Models\AssetCategory;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class EditAssetController extends Controller
{
    public function show(Request $request)
    {
        $asset = Asset::where('id', $request->asset_id)->first();
        $sites = Location::all();
        $categories = AssetCategory::orderBy('display_name')->get();
        $asset->load(['workDone' => function ($query) {
            $query->orderBy('date', 'desc');
        }]);
        return view('edit_asset', ['asset' => $asset, 'sites' => $sites, 'categories' => $categories]);
    }

    public function show_barcode(Request $request)
    {
        $asset = Asset::where('barcode', $request->barcode)->first();
        $sites = Location::all();
        $categories = AssetCategory::orderBy('display_name')->get();
        return view('edit_asset', ['asset' => $asset, 'sites' => $sites, 'categories' => $categories]);
    }

    public function handleEOLAsset(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $id = $request->id;
        Log::info("eoling $id");
        $asset = Asset::where('id', $request->id)->first();
        $asset->eol = true;
        $asset->save();
        return redirect()->back()->with('status', 'Asset has been successfully marked as EOL');
    }

    public function handleUndoEOLAsset(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $id = $request->id;
        Log::info("eoling $id");
        $asset = Asset::where('id', $request->id)->first();
        $asset->eol = false;
        $asset->save();
        return redirect()->back()->with('status', 'Asset has been successfully marked as EOL');
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

        $matching_company = AssetCompany::where('name', $request->get("company"))->first();
        $asset->company = $matching_company->id;
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
