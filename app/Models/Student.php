<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'user_id', 'global_status', 'is_jhs_alumni', 'is_shs_alumni',
    'grade_level', 'psa_no', 'lrn', 'last_name', 'first_name', 'middle_name', 'extension_name', 'birthdate', 'sex',
    'is_ip', 'ip_community', 'is_4ps', 'household_id', 'has_disability', 'disability_types',
    'current_house_no', 'current_street', 'current_barangay', 'current_municipality', 'current_province', 'current_zip',
    'is_same_address', 'permanent_house_no', 'permanent_street', 'permanent_barangay', 'permanent_municipality', 'permanent_province', 'permanent_zip',
    'father_name', 'mother_maiden_name', 'guardian_name', 'contact_no',
    'last_grade_level', 'last_school_year', 'last_school_attended', 'last_school_id'
])]
class Student extends Model
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
            'is_jhs_alumni' => 'boolean',
            'is_shs_alumni' => 'boolean',
            'is_ip' => 'boolean',
            'is_4ps' => 'boolean',
            'has_disability' => 'boolean',
            'is_same_address' => 'boolean',
            'disability_types' => 'array',
        ];
    }

    /**
     * Get the user account associated with the student.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the enrollments for the student.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
}
