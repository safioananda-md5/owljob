<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecentActivity extends Model
{
    protected $table = "recent_activity";
    protected $fillable = [
        'type',
        'amount',
        'user',
        'description',
    ];
}
