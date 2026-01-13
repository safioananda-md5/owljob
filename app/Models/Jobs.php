<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    protected $table = "jobs_owl";
    protected $fillable = [
        'cust_name',
        'job_name',
        'due_date',
        'price',
        'status',
    ];
}
