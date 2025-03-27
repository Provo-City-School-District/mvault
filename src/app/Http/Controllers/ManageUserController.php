<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permissions;


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
            return redirect("/")->with('status', 'User is not authorized to do this action');

        $user = User::where('id', $request->id)->first();
        $permissions = Permissions::where('id', $user->id)->first();
        return view('manage_user', ['user' => $user, 'permissions' => $permissions]);
    }

    public function updateUser(Request $request)
    {
        $permissions = Auth::user()->permissions;
        if (!$permissions->admin)
            return redirect("/")->with('status', 'User is not authorized to do this action');

        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255'
        ]);

        $user = User::where('id', $request->id)->first();
        $permissions = Permissions::where('id', $request->id)->first();

        $user->name = $request->name;


        $permissions->admin = $request->has("is_admin");
        $permissions->can_create_assets = $request->has('can_create_assets');
        $permissions->can_edit_assets = $request->has('can_edit_assets');
        $permissions->can_schedule_work = $request->has('can_schedule_work');
        $permissions->can_do_work = $request->has('can_do_work');

        $user->save();
        $permissions->save();

        return redirect()->back()->with('status', 'User has been successfully updated');
    }
}
