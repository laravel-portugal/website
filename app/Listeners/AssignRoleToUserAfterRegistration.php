<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;

class AssignRoleToUserAfterRegistration
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(Registered $event)
    {
        // Assign the user role
        if (! $event->user->hasRole('user')) {
            $event->user->assignRole('user');
        }
    }
}
