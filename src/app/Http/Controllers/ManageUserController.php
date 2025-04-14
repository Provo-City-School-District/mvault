<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permissions;
use App\Models\AssetLog;


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

        // Store original values before making changes
        $originalUser = $user->getOriginal();
        $originalPermissions = $permissions->getOriginal();

        // Update user and permissions
        $user->name = $request->name;

        // Cast incoming values to match the original types
        $permissions->admin = (bool) $request->has("is_admin");
        $permissions->can_create_assets = (bool) $request->has('can_create_assets');
        $permissions->can_edit_assets = (bool) $request->has('can_edit_assets');
        $permissions->can_schedule_work = (bool) $request->has('can_schedule_work');
        $permissions->can_do_work = (bool) $request->has('can_do_work');

        $user->save();
        $permissions->save();

        // Get changes
        $changes = [];

        // Compare user changes, excluding timestamps
        foreach ($user->getAttributes() as $field => $newValue) {
            if (in_array($field, ['created_at', 'updated_at'])) {
                continue; // Skip timestamps
            }

            $originalValue = $originalUser[$field] ?? null;
            if ($originalValue != $newValue) { // handle type consistency
                $changes['user'][$field] = [
                    'original' => $originalValue,
                    'updated' => $newValue
                ];
            }
        }

        // Compare permissions changes, excluding timestamps
        foreach ($permissions->getAttributes() as $field => $newValue) {
            if (in_array($field, ['created_at', 'updated_at'])) {
                continue; // Skip timestamps
            }

            $originalValue = $originalPermissions[$field] ?? null;

            // Ensure type consistency for boolean fields
            if (is_bool($originalValue)) {
                $newValue = (bool) $newValue;
            }

            if ($originalValue != $newValue) { // handle type consistency
                $changes['permissions'][$field] = [
                    'original' => $originalValue,
                    'updated' => $newValue
                ];
            }
        }

        // Log the changes
        if (!empty($changes)) {
            AssetLog::create([
                'user_id' => Auth::id(),
                'action' => 'Updated User',
                'details' => json_encode($changes)
            ]);
        }

        return redirect()->back()->with('status', 'User has been successfully updated');
    }
}
