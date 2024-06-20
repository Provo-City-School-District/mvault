<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Location;

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
        return view('create_asset', ['sites' => $sites]);
    }

    public function handleForm(Request $request)
    {
        
        $asset = new Asset;
        $asset->company = $request->get("company");
        $asset->model = $request->get("model");

        $site_number = $request->get("site_number");
        $asset->site = Location::where('site_number', $site_number)->first()->id;
        $asset->room = $request->get("room");

        $asset->notes = $request->get("notes");
        $asset->save();

        return redirect()->back();
    }
}