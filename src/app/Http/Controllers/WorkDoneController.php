<?php

namespace App\Http\Controllers;

use App\Models\WorkDone;
use App\Models\Asset;
use Illuminate\Http\Request;

class WorkDoneController extends Controller
{
    public function store(Request $request, Asset $asset)
    {
        $request->validate([
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $asset->workDone()->create($request->all());

        return redirect()->route('edit_asset', $asset->id)->with('status', 'Work done added successfully!');
    }
}
