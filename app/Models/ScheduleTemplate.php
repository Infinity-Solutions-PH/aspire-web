<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'grade_level', 'type'])]
class ScheduleTemplate extends Model
{
    public function slots(): HasMany
    {
        return $this->hasMany(ScheduleTemplateSlot::class);
    }
}
