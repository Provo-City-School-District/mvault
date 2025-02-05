<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Location;
use App\Models\AssetCategory;

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

        $category = $request->get("category");
        if (!isset($category)) {
            return redirect()->back()->withErrors(['form_validation' => 'Category not set']);
        }
    
        $site_number = $request->get("site_number");
        if (!isset($site_number)) {
            return redirect()->back()->withErrors(['form_validation' => 'Site not set']);
        }

        $purchase_date = $request->get("purchase_date");
        if (!isset($purchase_date)) {
            return redirect()->back()->withErrors(['form_validation' => 'Purchase date not set']);
        }

        $projected_lifetime = $request->integer("projected_lifetime");
        if (!isset($projected_lifetime)) {
            return redirect()->back()->withErrors(['form_validation' => 'Projected lifetime not set']);
        }

        $projected_lifetime_units = $request->get("projected_lifetime_units");
        if (!isset($projected_lifetime_units)) {
            return redirect()->back()->withErrors(['form_validation' => 'Projected lifetime units not set']);
        }

        $valid_projected_lifetime_units = ["years", "months", "days"];
        if (!in_array($projected_lifetime_units, $valid_projected_lifetime_units, true)) {
            return redirect()->back()->withErrors(['form_validation' => "Projected lifetime units are invalid: $projected_lifetime_units"]);
        }


        $asset = new Asset;
        $asset->name = $request->get("asset_name");
        $asset->serial = $request->get("serial");
        $asset->barcode = $request->get("barcode");

        $asset->company = $request->get("company");
        $asset->model = $request->get("model");

        $asset->category = $category;
        $asset->site = Location::where('site_number', $site_number)->first()->id;
        $asset->room = $request->get("room");

        $asset->purchase_price = $request->get("purchase_price");
        $asset->purchase_date = $purchase_date;
        $asset->projected_eol_date = Asset::calculate_projected_eol_date($purchase_date, $projected_lifetime, $projected_lifetime_units);

        $asset->description = $request->get("description");
        $asset->save();

        return redirect()->back()->with('status', 'Asset has been successfully created');
    }
}
