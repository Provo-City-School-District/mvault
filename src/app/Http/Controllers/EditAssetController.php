<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\ScheduledMaintenance;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function scheduleMaintenance(Request $request, $assetId)
    {
        $request->validate([
            'description' => 'required',
            'date' => 'required|date',
        ]);

        $maintenance = new ScheduledMaintenance();
        $maintenance->asset_id = $assetId;
        $maintenance->description = $request->description;
        $maintenance->date = $request->date;
        $maintenance->interval = $request->interval;
        $maintenance->user_id = Auth::id();
        $maintenance->save();

        return redirect()->back()->with('status', 'Maintenance has been successfully scheduled');
    }
    public function deleteMaintenance($id)
    {
        $maintenance = ScheduledMaintenance::findOrFail($id);
        $maintenance->delete();

        return redirect()->back()->with('status', 'Maintenance has been successfully deleted');
    }
}
