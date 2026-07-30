<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    protected $casts = [
        'title' => 'array',
        'date' => 'array',
        'description' => 'array',
        'content' => 'array',
    ];
}
