<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ManageUserController extends Controller
{
    public function show(Request $request)
    {
        $permissions = Auth::user()->permissions;
        if (!$permissions->admin)
            return redirect()->back()->with('status', 'User is not authorized to do this action');

        $user = User::where('id', $request->id)->first();
        $permissions = Auth::user()->permissions;
        return view('manage_user', ['user' => $user, 'permissions' => $permissions]);
    }

    public function updateUser(Request $request)
    {

    }
}