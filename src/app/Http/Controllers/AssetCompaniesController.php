<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCompany;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class AssetCompaniesController extends Controller
{
    public function show()
    {
        $companies = AssetCompany::orderBy('name')->get();
        return view('asset_companies', ['companies' => $companies]);
    }

    public function handleForm(Request $request)
    {
        
    }
}
