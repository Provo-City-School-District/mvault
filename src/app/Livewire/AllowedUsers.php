<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Asset;
use App\Models\AssetCompany;
use Illuminate\Support\Facades\DB;

class AllowedUsers extends Component
{
    public $username;
    public $usernames;

    public function mount()
    {
        $this->usernames = DB::table('allowed_users')->pluck('username');
    }

    public function addUser()
    {  
        $exists = DB::table('allowed_users')->where('username', $this->username)->exists();
        if (!$exists) {
            DB::table('allowed_users')->insert([
                'username' => $this->username
            ]);
        
            $this->usernames->push($this->username);
            $this->username = '';
        } else {
            session()->flash('error', 'This user already exists');
        }
    }

    public function removeUser(string $username)
    {
        $exists = DB::table('allowed_users')->where('username', $username)->exists();

        if ($exists) {
            DB::table('allowed_users')->where('username', $username)->delete();
            $this->usernames = $this->usernames->reject(fn($user) => $user == $username);
        }
    }

    public function render()
    {
        return view('livewire.allowed-users');
    }
}
