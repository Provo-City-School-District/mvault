<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetCompany;
use App\Models\Permissions;
use App\Models\ScheduledMaintenance;
use App\Models\WorkDone;
use App\Models\AssetLog;

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
        return view('edit_asset', ['asset' => $asset, 'sites' => $sites, 'categories' => $categories, 'permissions' => Auth::user()->permissions]);
    }





    public function show_barcode(Request $request)
    {
        $asset = Asset::where('barcode', $request->barcode)->first();
        $sites = Location::all();
        $categories = AssetCategory::orderBy('display_name')->get();
        return view('edit_asset', ['asset' => $asset, 'sites' => $sites, 'categories' => $categories, 'permissions' => Auth::user()->permissions]);
    }





    public function handleEOLAsset(Request $request)
    {
        $permissions = Auth::user()->permissions;
        if (!$permissions->admin)
            return redirect()->back()->with('status', 'User is not authorized to do this action');
        $request->validate([
            'id' => 'required'
        ]);
        $id = $request->id;
        Log::info("eoling $id");
        $asset = Asset::where('id', $request->id)->first();

        // Default original EOL status to false if not set
        $originalEOLStatus = $asset->eol ?? false;

        $asset->eol = true;
        $asset->save();

        // Log the EOL action
        AssetLog::create([
            'user_id' => Auth::id(),
            'asset_id' => $asset->id,
            'action' => 'Marked Asset as EOL',
            'details' => json_encode([
                'original_eol_status' => $originalEOLStatus,
                'updated_eol_status' => $asset->eol,
                'asset_id' => $asset->id,
            ]),
        ]);

        return redirect()->back()->with('status', 'Asset has been successfully marked as EOL');
    }





    public function handleUndoEOLAsset(Request $request)
    {
        $permissions = Auth::user()->permissions;
        if (!$permissions->admin)
            return redirect()->back()->with('status', 'User is not authorized to do this action');
        $request->validate([
            'id' => 'required'
        ]);
        $id = $request->id;
        Log::info("eoling $id");
        $asset = Asset::where('id', $request->id)->first();
        $originalEOLStatus = $asset->eol;

        $asset->eol = false;
        $asset->save();

        // Log the Undo EOL action
        AssetLog::create([
            'user_id' => Auth::id(),
            'asset_id' => $asset->id,
            'action' => 'Unmarked Asset as EOL',
            'details' => json_encode([
                'original_eol_status' => $originalEOLStatus,
                'updated_eol_status' => $asset->eol,
                'asset_id' => $asset->id,
            ]),
        ]);

        return redirect()->back()->with('status', 'Asset has been successfully marked as EOL');
    }





    public function handleForm(Request $request)
    {
        $permissions = Auth::user()->permissions;
        if (!$permissions->can_edit_assets && !$permissions->admin)
            return redirect()->back()->with('status', 'User is not authorized to do this action');
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

        // Store original values before making changes
        $originalAsset = $asset->getOriginal();

        // Update asset fields
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

        // Get changes
        $changes = [];
        foreach ($asset->getAttributes() as $field => $newValue) {
            if (in_array($field, ['created_at', 'updated_at'])) {
                continue; // Skip timestamps
            }

            $originalValue = $originalAsset[$field] ?? null;
            if ($originalValue != $newValue) { // Log only changed fields
                $changes[$field] = [
                    'original' => $originalValue,
                    'updated' => $newValue
                ];
            }
        }

        // Log the changes
        if (!empty($changes)) {
            $changes['asset_id'] = $asset->id;
            AssetLog::create([
                'user_id' => Auth::id(),
                'asset_id' => $asset->id,
                'action' => 'Updated Asset',
                'details' => json_encode($changes)
            ]);
        }

        return redirect()->back()->with('status', 'Asset has been successfully updated');
    }





    public function scheduleMaintenance(Request $request, $assetId)
    {
        $permissions = Auth::user()->permissions;
        if (!$permissions->can_schedule_work && !$permissions->admin)
            return redirect()->back()->with('status', 'User is not authorized to do this action');

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

        // Log the scheduling of maintenance
        AssetLog::create([
            'user_id' => Auth::id(),
            'asset_id' => $assetId,
            'action' => 'Created Scheduled Maintenance',
            'details' => json_encode([
                'description' => $maintenance->description,
                'asset_id' => $maintenance->asset_id,
                'date' => $maintenance->date,
                'interval' => $maintenance->interval,
            ]),
        ]);

        return redirect()->back()->with('status', 'Maintenance has been successfully scheduled');
    }





    public function deleteMaintenance($id)
    {
        $permissions = Auth::user()->permissions;
        if (!$permissions->can_schedule_work && !$permissions->admin)
            return redirect()->back()->with('status', 'User is not authorized to do this action');

        $maintenance = ScheduledMaintenance::findOrFail($id);

        // Log the deletion of maintenance
        AssetLog::create([
            'user_id' => Auth::id(),
            'asset_id' => $maintenance->asset_id,
            'action' => 'Deleted Scheduled Maintenance',
            'details' => json_encode([
                'description' => $maintenance->description,
                'date' => $maintenance->date,
                'asset_id' => $maintenance->asset_id,
                'interval' => $maintenance->interval,
            ]),
        ]);

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
                    'due_date' => now()->addDays(10),
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
                $task->date = now(); // Set the date to the current date
                $task->date = $task->nextDate(); // Calculate the next scheduled date
                $task->save();
            }
        });

        return response()->json(['status' => 'Scheduled tasks handled successfully']);
    }
}
