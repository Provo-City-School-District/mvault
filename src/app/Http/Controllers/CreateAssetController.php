<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
 
class CreateAssetController extends Controller
{
    public function show()
    {
        return view('create_asset');
    }

    public function handleForm(Request $request)
    {
        Log::info($request->get("asset_name"));
        return redirect()->back();
    }
}