<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'student_id', 'school_year_id', 'transaction_number', 'status', 'current_step', 'type',
    'grade_level', 'section_id', 'tech_voc_section_id',
    'last_grade_level', 'last_school_year', 'last_school_attended', 'last_school_id',
    'semester', 'track', 'strand', 'shs_track', 'is_shs_aligned', 'specialization', 'tech_voc_choices', 'modality',
    'gwa', 'admin_remarks', 'verified_by', 'finalized_at'
])]
class Enrollment extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_shs_aligned' => 'boolean',
            'tech_voc_choices' => 'array',
            'finalized_at' => 'datetime',
            'gwa' => 'decimal:2',
        ];
    }

    /**
     * Get the student that owns the enrollment.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the school year of the enrollment.
     */
    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }

    /**
     * Get the user who verified the enrollment.
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get the section assigned to the enrollment.
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the tech voc section assigned to the enrollment.
     */
    public function techVocSection(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'tech_voc_section_id');
    }

    /**
     * Get the school category based on grade level.
     */
    public function getSchoolCategoryAttribute(): string
    {
        $grade = (int) str_replace('Grade ', '', $this->grade_level);
        return ($grade >= 11) ? 'Senior High School' : 'High School';
    }
}
