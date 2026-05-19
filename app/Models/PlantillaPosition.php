<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PlantillaPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'plantilla_number',
        'position_id',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function faculty(): HasOne
    {
        return $this->hasOne(Faculty::class);
    }
}
