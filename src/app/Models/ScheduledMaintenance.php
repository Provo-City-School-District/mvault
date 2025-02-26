<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ScheduledMaintenance extends Model
{
    // use HasFactory;

    protected $table = 'scheduled_maintenance';

    protected $fillable = [
        'asset_id',
        'user_id',
        'description',
        'date',
        'interval',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function nextDate()
    {
        return Carbon::parse($this->date)->addDays($this->interval)->toDateString();
    }
}
