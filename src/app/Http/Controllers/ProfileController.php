<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user_data = Auth::user();
        return view('profile', ["name" => $user_data->name, "email" => $user_data->email]);
    }
}