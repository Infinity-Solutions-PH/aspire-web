<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['building_id', 'name', 'type', 'capacity', 'floor'])]
class Room extends Model
{
    /**
     * Get the building that owns the room.
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }
    /**
     * Get the schedules associated with this room.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Get the sections associated with this room.
     */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }
}
