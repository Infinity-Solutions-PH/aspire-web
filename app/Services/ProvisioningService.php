<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class ProvisioningService
{
    /**
     * Automatically generate institutional email and provision mock accounts.
     */
    public function provisionAccount(User $user): void
    {
        // 1. Generate institutional email
        $nameParts = explode(' ', strtolower($user->name));
        $firstName = $nameParts[0];
        $lastName = end($nameParts);
        $institutionalEmail = "{$firstName}.{$lastName}@tnts.edu.ph";

        // Check for duplicates
        if (User::where('email', $institutionalEmail)->exists()) {
            $institutionalEmail = "{$firstName}.{$lastName}" . Str::lower(Str::random(2)) . "@tnts.edu.ph";
        }

        // 2. Update user record (this becomes their primary login for the portal)
        // In a real system, we'd trigger a webhook to Google Workspace or Moodle here.
        $user->update([
            'email' => $institutionalEmail,
            // 'is_provisioned' => true, // Imagine we have a field for this
        ]);

        // 3. Mock LMS Provisioning
        // Log::info("Moodle account created for: {$institutionalEmail}");
    }
}
