<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'grade_level', 'track', 'strand', 'specialization'])]
class Subject extends Model
{
    /**
     * Get the schedules associated with this subject.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
