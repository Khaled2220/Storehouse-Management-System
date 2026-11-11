<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function getAllUsers(): LengthAwarePaginator
    {
        return User::latest()->paginate(10);
    }

    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function updateUser(User $user, array $data): User
    {
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }
        $user->update($data);

        return $user->refresh();
    }

    public function deleteUser(User $user): bool
    {
        return (bool) $user->delete();
    }
}
