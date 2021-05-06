<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Domains\Accounts\Enums\AccountTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'account_type' => AccountTypeEnum::USER,
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
            'trusted' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function unverified(): self
    {
        return $this->state([
            'email_verified_at' => null,
        ]);
    }

    public function withPersonalTeam(): self
    {
        return $this->has(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['name' => $user->name . '\'s Team', 'user_id' => $user->id, 'personal_team' => true];
                }),
            'ownedTeams'
        );
    }

    public function editor(): self
    {
        return $this->state([
            'account_type' => AccountTypeEnum::EDITOR,
        ]);
    }

    public function admin(): self
    {
        return $this->state([
            'account_type' => AccountTypeEnum::ADMIN,
        ]);
    }

    public function deleted(): self
    {
        return $this->state([
            'deleted_at' => Carbon::now(),
        ]);
    }

    public function trusted(): self
    {
        return $this->state([
            'trusted' => true,
        ]);
    }

    public function withRole(string $role): self
    {
        return $this->state([
            'account_type' => $role,
        ]);
    }
}
