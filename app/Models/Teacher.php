<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'teacher_id',
        'department',
        'status',
        'specialization'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'teacher_id', 'user_id');
    }

    /**
     * Get sections where this teacher is the adviser
     * (Assuming we might add adviser_id to sections later, but for now we can check schedules)
     */
    public function assignedSections()
    {
        return $this->schedules()->with('section')->get()->pluck('section')->unique();
    }
}
