<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = [
        'name',
        'org_chart_image',
        'mission',
        'vision',
        'goals',
        'custom_sections'
    ];

    protected $casts = [
        'name' => 'array',
        'mission' => 'array',
        'vision' => 'array',
        'goals' => 'array',
        'custom_sections' => 'array',
    ];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
