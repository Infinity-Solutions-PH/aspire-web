<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Database\Factories\UserFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['name', 'email', 'password', 'google_id', 'avatar', 'student_id'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function faculty()
    {
        return $this->hasOne(Faculty::class);
    }

    /**
     * Get the student's violations through the student record.
     */
    public function violations()
    {
        return $this->hasManyThrough(
            Violation::class,
            Student::class,
            'user_id', // Foreign key on students table...
            'student_id', // Foreign key on violations table...
            'id', // Local key on users table...
            'id' // Local key on students table...
        );
    }

    /**
     * Get the violations recorded by this user.
     */
    public function recordedViolations()
    {
        return $this->hasMany(Violation::class, 'recorded_by');
    }

    /**
     * Get the student record for this user.
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Get the student's enrollments through the student record.
     */
    public function enrollments()
    {
        return $this->hasManyThrough(
            Enrollment::class,
            Student::class,
            'user_id', // Foreign key on students table...
            'student_id', // Foreign key on enrollments table...
            'id', // Local key on users table...
            'id' // Local key on students table...
        );
    }
}

