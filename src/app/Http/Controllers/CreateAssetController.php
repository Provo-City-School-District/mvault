<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Location;
use App\Models\AssetCategory;
use App\Models\AssetCompany;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class CreateAssetController extends Controller
{
    public function show()
    {
        $sites = Location::orderBy('display_name')->get();
        $categories = AssetCategory::orderBy('display_name')->get();
        return view('create_asset', ['sites' => $sites, 'categories' => $categories]);
    }

    public function handleForm(Request $request)
    {
        $request->validate([
            'asset_name' => 'required',
            'serial' => 'required',
            'company' => 'required',
            'category' => 'required',
            'model' => 'required',
            'site_number' => 'required',
            'purchase_price' => 'required',
            'purchase_date' => 'required',
            'projected_lifetime' => 'required',
            'projected_lifetime_units' => 'required|in:years,days,months'
        ]);

        $asset = new Asset;
        $asset->name = $request->get("asset_name");
        $asset->serial = $request->get("serial");
        $asset->barcode = $request->get("barcode");

        $matching_company = AssetCompany::where('name', $request->get("company"))->first();
        $asset->company = $matching_company->id;
        $asset->model = $request->get("model");

        $asset->category = $request->get("category");
        $asset->site = Location::where('site_number', $request->get("site_number"))->first()->id;
        $asset->room = $request->get("room");

        $asset->purchase_price = $request->get("purchase_price");
        $asset->purchase_date = $request->get("purchase_date");
        $asset->projected_eol_date = Asset::calculate_projected_eol_date(
            $asset->purchase_date, (int)$request->get("projected_lifetime"), $request->get("projected_lifetime_units"));

        $asset->description = $request->get("description");
        $asset->save();

        return redirect()->back()->with('status', 'Asset has been successfully created');
    }
}
