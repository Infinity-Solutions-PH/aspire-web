<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['lrn', 'birthdate', 'transaction_number', 'current_step', 'status', 'form_data'])]
class PreEnrollment extends Model
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
            'form_data' => 'array',
        ];
    }
}
