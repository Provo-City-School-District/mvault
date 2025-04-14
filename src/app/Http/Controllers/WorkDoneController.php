<?php

namespace App\Http\Controllers;

use App\Models\WorkDone;
use App\Models\Asset;
use App\Models\AssetLog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkDoneController extends Controller
{





    public function store(Request $request, Asset $asset)
    {
        $permissions = Auth::user()->permissions;
        if (!$permissions->can_do_work && !$permissions->admin)
            return redirect()->back()->with('status', 'User is not authorized to do this action');
        $request->validate([
            'description' => 'required|string',
            'date' => 'required|date',
            'ticket_id' => 'required|integer',
        ]);

        $workDone = new WorkDone($request->all());
        $workDone->user_id = Auth::id();
        $workDone->asset_id = $asset->id;
        $workDone->save();

        // Log the creation of work done
        AssetLog::create([
            'user_id' => Auth::id(),
            'asset_id' => $asset->id,
            'action' => 'Created Work Done',
            'details' => json_encode([
                'description' => $workDone->description,
                'asset_id' => $asset->id,
                'date' => $workDone->date,
                'ticket_id' => $workDone->ticket_id,
            ]),
        ]);

        return redirect()->route('edit_asset', $asset->id)->with('status', 'Work done added successfully!');
    }





    public function edit(Asset $asset)
    {
        $asset->load('workDone.user');

        return view('edit_asset', compact('asset'));
    }
}
