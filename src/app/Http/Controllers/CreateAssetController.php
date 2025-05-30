<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Location;
use App\Models\AssetCategory;
use App\Models\AssetCompany;
use App\Models\AssetLog;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class CreateAssetController extends Controller
{





    public function show()
    {
        $permissions = Auth::user()->permissions;
        if (!$permissions->can_create_assets && !$permissions->admin)
            return redirect()->back()->with('status', 'User is not authorized to do this action');

        $sites = Location::orderBy('display_name')->get();
        $categories = AssetCategory::orderBy('display_name')->get();
        return view('create_asset', ['sites' => $sites, 'categories' => $categories]);
    }





    public function handleForm(Request $request)
    {
        $permissions = Auth::user()->permissions;
        if (!$permissions->can_create_assets && !$permissions->admin)
            return redirect()->back()->with('status', 'User is not authorized to do this action');

        $request->validate([
            'asset_name' => 'required',
            'serial' => 'required',
            'company' => 'required|exists:asset_companies,name',
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
        if (!$matching_company) {
            return redirect()->back()->withErrors(['company' => 'Please select a valid company from the dropdown.']);
        }
        $asset->company = $matching_company->id;
        $asset->model = $request->get("model");

        $asset->category = $request->get("category");
        $asset->site = Location::where('site_number', $request->get("site_number"))->first()->id;
        $asset->room = $request->get("room");

        $asset->purchase_price = $request->get("purchase_price");
        $asset->purchase_date = $request->get("purchase_date");
        $asset->projected_eol_date = Asset::calculate_projected_eol_date(
            $asset->purchase_date,
            (int)$request->get("projected_lifetime"),
            $request->get("projected_lifetime_units")
        );

        $asset->description = $request->get("description");
        $asset->save();


        // Log the creation of the asset
        AssetLog::create([
            'user_id' => Auth::id(),
            'asset_id' => $asset->id,
            'action' => 'Created Asset',
            'details' => json_encode([
                'name' => $asset->name,
                'serial' => $asset->serial,
                'barcode' => $asset->barcode,
                'company' => $matching_company->name,
                'model' => $asset->model,
                'category' => $asset->category,
                'site' => $asset->site,
                'room' => $asset->room,
                'purchase_price' => $asset->purchase_price,
                'purchase_date' => $asset->purchase_date,
                'projected_eol_date' => $asset->projected_eol_date,
                'description' => $asset->description,
            ]),
        ]);

        return redirect()->back()->with('status', 'Asset has been successfully created');
    }
}
