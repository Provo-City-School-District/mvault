<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkDone extends Model
{
    use HasFactory;

    protected $fillable = ['asset_id', 'description', 'date', 'ticket_id', 'user_id'];
    protected $table = 'work_done';

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
