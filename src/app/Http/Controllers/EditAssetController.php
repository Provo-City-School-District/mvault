<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetCompany;
use App\Models\ScheduledMaintenance;
use App\Models\WorkDone;

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

    public function processScheduledTasks()
    {
        // Fetch scheduled maintenance tasks that are due in chunks
        ScheduledMaintenance::where('date', '<=', now())->chunk(100, function ($dueTasks) {
            foreach ($dueTasks as $task) {
                // Insert a ticket into the helpdesk system
                $ticketId = DB::connection('help-db')->table('tickets')->insertGetId([
                    'description' => $task->description,
                    'created' => now(),
                    'name' => 'Scheduled Maintenance For Asset: ' . $task->asset->name,
                    'client' => 'donotreply',
                    'last_updated' => now(),
                    'department' => '1700',
                    'location' => Location::find($task->asset->site)->site_number,
                    'priority' => '10',
                    'status' => 'open',
                    'request_type_id' => 0,
                ]);

                // Add an entry into the work done table with the ticket number
                WorkDone::create([
                    'asset_id' => $task->asset_id,
                    'description' => $task->description,
                    'date' => now(),
                    'ticket_id' => $ticketId,
                    'user_id' => $task->user_id,
                ]);

                // Update the next scheduled date for the task
                $task->date = $task->nextDate();
                $task->save();
            }
        });

        return response()->json(['status' => 'Scheduled tasks handled successfully']);
    }
}
