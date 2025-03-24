<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function show()
    {
        $permissions = Auth::user()->permissions;
        if (!$permissions->admin)
            return redirect()->back()->with('status', 'User is not authorized to do this action');

        return view('admin');
    }
}