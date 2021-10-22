<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use App\Types\PermissionsType;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return null !== $user;
    }

    public function view(User $user, Tag $tag)
    {
        return null !== $user;
    }

    public function create(User $user)
    {
        return $user->can(PermissionsType::moderate_tags()->value);
    }

    public function edit(User $user, Tag $tag)
    {
        return $user->can(PermissionsType::moderate_tags()->value);
    }

    public function update(User $user, Tag $tag)
    {
        return $user->can(PermissionsType::moderate_tags()->value);
    }

    public function destroy(User $user, Tag $tag)
    {
        return $user->can(PermissionsType::moderate_tags()->value);
    }

    public function restore(User $user, Tag $tag)
    {
        return $user->can(PermissionsType::moderate_tags()->value) && null === $tag->deleted_at;
    }

    public function destroyForce(User $user, Tag $tag)
    {
        return $user->can(PermissionsType::moderate_tags()->value) && $tag->deleted_at !== null;
    }
}
