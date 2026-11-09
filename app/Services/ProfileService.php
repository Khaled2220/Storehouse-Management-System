<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    /**
     * Update the user's profile.
     */
    public function updateProfile(User $user, array $data): User
    {
        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();

        return $user->refresh();
    }

    /**
     * Delete the user's profile and log them out.
     */
    public function deleteProfile(User $user, Request $request): bool
    {
        $deleted = (bool) $user->delete();

        if (! $deleted) {
            return false;
        }
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return true;
    }
}
