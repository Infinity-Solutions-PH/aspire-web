<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'type', 'capacity'])]
class Room extends Model
{
    /**
     * Get the schedules associated with this room.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
