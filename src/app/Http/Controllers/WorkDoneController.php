<?php

namespace App\Http\Controllers;

use App\Models\WorkDone;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkDoneController extends Controller
{
    public function store(Request $request, Asset $asset)
    {
        $request->validate([
            'description' => 'required|string',
            'date' => 'required|date',
            'ticket_id' => 'required|integer',
        ]);

        $workDone = new WorkDone($request->all());
        $workDone->user_id = Auth::id();
        $workDone->asset_id = $asset->id;
        $workDone->save();

        return redirect()->route('edit_asset', $asset->id)->with('status', 'Work done added successfully!');
    }
}
