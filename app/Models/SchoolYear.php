<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    protected $fillable = [
        'name',
        'status',
        'enrollment_start',
        'enrollment_end',
        'classes_start',
    ];

    protected $casts = [
        'enrollment_start' => 'date',
        'enrollment_end' => 'date',
        'classes_start' => 'date',
    ];
}
