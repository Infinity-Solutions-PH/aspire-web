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

    // Proxy accessors to the related Student model for seamless property access
    public function getFirstNameAttribute() { return $this->student->first_name ?? null; }
    public function getLastNameAttribute() { return $this->student->last_name ?? null; }
    public function getMiddleNameAttribute() { return $this->student->middle_name ?? null; }
    public function getExtensionNameAttribute() { return $this->student->extension_name ?? null; }
    public function getLrnAttribute() { return $this->student->lrn ?? null; }
    public function getBirthdateAttribute() { return $this->student->birthdate ?? null; }
    public function getSexAttribute() { return $this->student->sex ?? null; }
    public function getContactNoAttribute() { return $this->student->contact_no ?? null; }
    public function getGuardianNameAttribute() { return $this->student->guardian_name ?? null; }
    public function getCurrentHouseNoAttribute() { return $this->student->current_house_no ?? null; }
    public function getCurrentStreetAttribute() { return $this->student->current_street ?? null; }
    public function getCurrentBarangayAttribute() { return $this->student->current_barangay ?? null; }
    public function getCurrentMunicipalityAttribute() { return $this->student->current_municipality ?? null; }
    public function getCurrentProvinceAttribute() { return $this->student->current_province ?? null; }
    public function getCurrentZipAttribute() { return $this->student->current_zip ?? null; }
    public function getIsSameAddressAttribute() { return $this->student->is_same_address ?? false; }
    public function getPermanentHouseNoAttribute() { return $this->student->permanent_house_no ?? null; }
    public function getPermanentStreetAttribute() { return $this->student->permanent_street ?? null; }
    public function getPermanentBarangayAttribute() { return $this->student->permanent_barangay ?? null; }
    public function getPermanentMunicipalityAttribute() { return $this->student->permanent_municipality ?? null; }
    public function getPermanentProvinceAttribute() { return $this->student->permanent_province ?? null; }
    public function getPermanentZipAttribute() { return $this->student->permanent_zip ?? null; }
    
    public function getPsaNoAttribute() { return $this->student->psa_no ?? null; }
    public function getMotherTongueAttribute() { return $this->student->mother_tongue ?? null; }
    public function getIsIpAttribute() { return $this->student->is_ip ?? false; }
    public function getIpCommunityAttribute() { return $this->student->ip_community ?? null; }
    public function getIs4psAttribute() { return $this->student->is_4ps ?? false; }
    public function getHouseholdIdAttribute() { return $this->student->household_id ?? null; }
    public function getFatherNameAttribute() { return $this->student->father_name ?? null; }
    public function getMotherMaidenNameAttribute() { return $this->student->mother_maiden_name ?? null; }


    public function getProfilePictureAttribute() { return $this->student->user->avatar ?? null; }

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
