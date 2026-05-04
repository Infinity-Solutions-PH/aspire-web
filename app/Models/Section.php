<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'is_star_section', 'room', 'adviser_id', 'grade_level', 'track', 'strand', 'specialization', 'capacity'])]
class Section extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_star_section' => 'boolean',
        ];
    }

    /**
     * Get the adviser for the section.
     */
    public function adviser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adviser_id');
    }
    /**
     * Get the schedules associated with this section.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Get the enrollments associated with this section.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the tech voc enrollments associated with this section.
     */
    public function techVocEnrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'tech_voc_section_id');
    }
}
