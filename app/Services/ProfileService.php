<?php

namespace App\Services;

use App\Models\User;

class ProfileService
{
    public function updateProfile(User $user, array $data): User
    {
        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return $user->refresh();
    }

    public function deleteProfile(User $user): bool
    {
        return (bool) $user->delete();
    }
}
