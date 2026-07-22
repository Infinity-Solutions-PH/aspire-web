<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name'])]
class Building extends Model
{
    /**
     * Get the rooms associated with this building.
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
