<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'signed_at'])]
class SafetyWaiver extends Model
{
    /**
     * Get the user that signed the waiver.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
