<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permissions;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        try {
            $google_user = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/')->withErrors(['login' => 'Failed to login']);
        }

        $user_name = $google_user->name;
        $user_email = $google_user->email;

        $domain = explode('@', $user_email);
        $account_username = strtolower($domain[0]);

        $domain_name = $domain[1];

        if ($domain_name != "provo.edu" || !GoogleLoginController::userAllowed($account_username)) {
            Log::info("User with email $user_email attempted to login... rejected");
            return redirect('/')->withErrors(['login' => 'User is not allowed to access this system']);
        }

        $user = User::where('email', $user_email)->first();
        if (!$user) {
            $user = User::create(['username' => $account_username, 'name' => $user_name, 'email' => $user_email]);
        }

        $user_id = $user->id;
        $permissions = Permissions::where('id', $user_id)->first();
        if (!$permissions) {
            $permissions = Permissions::create(['id' => $user_id]);
        }

        $user->last_login = Carbon::now()->toDateTimeString();
        $user->save();
        Auth::login($user, true);

        return redirect()->intended('profile');
    }

    public static function userAllowed(string $username) {
        return DB::table('allowed_users')->where('username', $username)->exists();
    }
}
