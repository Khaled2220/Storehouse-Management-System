<?php

namespace App\Policies;

use App\Models\Categorios;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any categories.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view a category.
     */
    public function view(User $user, Categorios $category): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create categories.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update a category.
     */
    public function update(User $user, Categorios $category): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete a category.
     */
    public function delete(User $user, Categorios $category): bool
    {
        return $user->isAdmin();
    }
}
