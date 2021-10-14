<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function created(User $user)
    {
        // Assign the user role
        if (! $user->hasRole('user')) {
            $user->assignRole('user');
        }
    }
}
