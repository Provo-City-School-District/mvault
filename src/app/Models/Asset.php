<?php

namespace App\Models;

use Carbon\Carbon;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    public static function calculate_projected_eol_date($date, $lifetime, $lifetime_units)
    {
        // calculate projected EOL date
        $projected_eol_date = Carbon::parse($date);
        switch ($lifetime_units) {
            case "years":
                return $projected_eol_date->addYears($lifetime);
                break;
            case "months":
                return $projected_eol_date->addMonths($lifetime);
                break;
            case "days":
                return $projected_eol_date->addDays($lifetime);
                break;
            default:
                return null;
        }
    }
    public function workDone()
    {
        return $this->hasMany(WorkDone::class);
    }
    public function scheduledMaintenance()
    {
        return $this->hasMany(ScheduledMaintenance::class);
    }
}
