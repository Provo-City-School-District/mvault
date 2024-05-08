<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

 
class CreateAssetController extends Controller
{
    public function show()
    {
        $sites = DB::select('SELECT display_name, site_number FROM locations ORDER BY display_name ASC');
        return view('create_asset', ['sites' => $sites]);
    }

    public function handleForm(Request $request)
    {
        $name = $request->get("asset_name");
        $site_number = $request->get("site");
        $site = DB::table('locations')->where('site_number', $site_number)->first();
        DB::insert('INSERT INTO assets (name, site) values (?, ?)', [$name, $site->id]);
        return redirect()->back();
    }
}