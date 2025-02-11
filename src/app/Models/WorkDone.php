<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkDone extends Model
{
    use HasFactory;

    protected $fillable = ['asset_id', 'description', 'date'];
    protected $table = 'work_done';

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
