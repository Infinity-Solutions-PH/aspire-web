<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('admin.login')->withErrors(['email' => __('Google authentication failed.')]);
        }

        // Find user by Google ID
        $user = User::where('google_id', $googleUser->getId())->first();

        if (!$user) {
            // Find user by email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Link Google account to existing user
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // Do not create a user
                return redirect()->route('admin.login')->withErrors(['email' => __('This Google account is not registered.')]);
            }
        } else {
            // Update avatar if changed
            $user->update(['avatar' => $googleUser->getAvatar()]);
        }

        // Check if faculty role and active
        if ($user->hasRole('faculty')) {
            if (!$user->faculty) {
                return redirect()->route('admin.login')->withErrors(['email' => __('Faculty profile not found.')]);
            }
            if ($user->faculty->status === 'Pending') {
                return redirect()->route('admin.login')->withErrors(['email' => __('Your account registration is pending approval.')]);
            }
            if ($user->faculty->status === 'Rejected') {
                return redirect()->route('admin.login')->withErrors(['email' => __('Your account registration has been rejected.')]);
            }
            if ($user->faculty->status === 'Inactive') {
                return redirect()->route('admin.login')->withErrors(['email' => __('Your account is inactive.')]);
            }
            if (!in_array($user->faculty->status, ['Active', 'On Leave'])) {
                return redirect()->route('admin.login')->withErrors(['email' => __('Your account is not active.')]);
            }
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
