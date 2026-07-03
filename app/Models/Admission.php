<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use \Illuminate\Database\Eloquent\Attributes\Fillable;

    protected $fillable = [
        'transaction_number',
        'lrn',
        'birthdate',
        'current_step',
        'status',
        'form_data'
    ];

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
