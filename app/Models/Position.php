<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    protected $fillable = ['name', 'type'];

    public function faculties(): HasMany
    {
        return $this->hasMany(Faculty::class);
    }

    /**
     * Scope a query to sort positions: Teaching first (low to high), then Non-Teaching.
     */
    public function scopeSortedForForm($query)
    {
        return $query->orderByRaw("CASE WHEN type = 'Teaching' THEN 1 ELSE 2 END")
            ->orderByRaw("CASE name
                WHEN 'Teacher I' THEN 1
                WHEN 'Teacher II' THEN 2
                WHEN 'Teacher III' THEN 3
                WHEN 'Master Teacher I' THEN 4
                WHEN 'Master Teacher II' THEN 5
                ELSE 6
            END")
            ->orderBy('name');
    }
}

