<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Faculty extends Model
{
    protected $table = 'faculties';

    protected $fillable = [
        'user_id',
        'faculty_id',
        'department',
        'status',
        'branch_id',
        'level',
        'plantilla_position_id',
        'gender',
        'resigned_date',
        'transfer_date'
    ];

    /**
     * Get the casts for model attributes.
     */
    protected function casts(): array
    {
        return [
            'resigned_date' => 'date',
            'transfer_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plantillaPosition(): BelongsTo
    {
        return $this->belongsTo(PlantillaPosition::class);
    }

    public function position(): HasOneThrough
    {
        return $this->hasOneThrough(
            Position::class, 
            PlantillaPosition::class, 
            'id', 
            'id', 
            'plantilla_position_id', 
            'position_id'
        );
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'teacher_id', 'user_id');
    }

    /**
     * Get sections where this faculty is the adviser
     */
    public function assignedSections()
    {
        return $this->schedules()->with('section')->get()->pluck('section')->unique();
    }
}
