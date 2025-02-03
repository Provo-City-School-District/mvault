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

        $asset = new Asset;
        $asset->serial = $request->get("serial");
        $asset->barcode = $request->get("barcode");

        $asset->company = $request->get("company");
        $asset->model = $request->get("model");

        $asset->category = $category;
        $asset->site = Location::where('site_number', $site_number)->first()->id;
        $asset->room = $request->get("room");
        $asset->program = $request->get("program");
        $asset->purchase_date = $request->get("purchase_date");
        $asset->expected_lifespan_seconds = $request->get("expected_lifespan_seconds");

        //$asset->notes = $request->get("notes") ?: "";
        $asset->save();

        return redirect()->back()->with('status', 'Asset has been successfully created');
    }
}
