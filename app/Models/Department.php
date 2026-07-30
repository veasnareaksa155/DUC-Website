<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'faculty_id',
        'name',
        'slug',
        'description',
        'mission',
        'vision',
        'goals',
        'custom_sections',
        'programs',
        'majors'
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'mission' => 'array',
        'vision' => 'array',
        'goals' => 'array',
        'custom_sections' => 'array',
        'programs' => 'array',
        'majors' => 'array',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
