<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'user_id', 'transaction_number', 'status', 'current_step', 'type', 'tech_voc_choices', 'profile_picture',
    'grade_level', 'psa_no', 'lrn', 'last_name', 'first_name', 'middle_name', 'extension_name', 'gwa', 'birthdate', 'sex',
    'is_ip', 'ip_community', 'is_4ps', 'household_id', 'has_disability', 'disability_types',
    'current_house_no', 'current_street', 'current_barangay', 'current_municipality', 'current_province', 'current_zip',
    'is_same_address', 'permanent_house_no', 'permanent_street', 'permanent_barangay', 'permanent_municipality', 'permanent_province', 'permanent_zip',
    'father_name', 'mother_maiden_name', 'guardian_name', 'contact_no',
    'last_grade_level', 'last_school_year', 'last_school_attended', 'last_school_id',
    'semester', 'track', 'strand', 'shs_track', 'is_shs_aligned', 'specialization', 'modality',
    'psa_path', 'sf9_path', 'good_moral_path', 'honorable_dismissal_path', 'admin_remarks', 'verified_by', 'finalized_at', 'section_id', 'tech_voc_section_id'
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
            'birthdate' => 'date',
            'is_ip' => 'boolean',
            'is_4ps' => 'boolean',
            'has_disability' => 'boolean',
            'is_same_address' => 'boolean',
            'is_shs_aligned' => 'boolean',
            'disability_types' => 'array',
            'tech_voc_choices' => 'array',
            'finalized_at' => 'datetime',
            'gwa' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the enrollment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
