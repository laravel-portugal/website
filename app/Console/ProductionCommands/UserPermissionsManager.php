<?php

namespace App\Console\ProductionCommands;

use App\Models\User;
use App\Types\RolesType;
use Illuminate\Console\Command;

class UserPermissionsManager extends Command
{
    protected $signature = 'permissions:manage';
    protected $description = 'Manage the permissions for users';

    public function handle()
    {
        // Find the email
        $email = $this->ask('Whats the user email address?', 'admin@admin.com');
        if (empty($email) || ! $user = User::whereEmail($email)->first()) {
            $this->error(sprintf('Sorry, we could not find a user with email : %s', $email));

            return;
        }

        // Checking for existing user roles
        $this->info(sprintf('The user has the following roles: %s', $user->roles->pluck('name')->implode(',')));

        $action = $this->choice(
            'Do you want to demote or promote this user?',
            [
                'promote' => '🏅 Promote',
                'demote' => '🥉 Demote',
            ],
            'promote',
        );

        $role = $this->choice(
            'Want role you want to add/remove?',
            RolesType::toLabels(),
            'role',
        );

        if ('promote' === $action) {
            $user->assignRole($role);
            $this->info(sprintf('🏅 The user %s was promoted to : %s', $user->email, $role));
        }

        if ('demote' === $action) {
            $user->removeRole($role);
            $this->info(sprintf('🥉 The user %s was demoted from the role : %s', $user->email, $role));
        }

        $this->info(sprintf('✅ All done! Current Roles are : %s', $user->fresh()->roles->pluck('name')->implode(',')));
    }
}
