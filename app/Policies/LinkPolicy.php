<?php

namespace App\Policies;

use App\Models\Link;
use App\Models\User;
use App\Types\LinkStatusType;
use App\Types\PermissionsType;
use Illuminate\Auth\Access\HandlesAuthorization;

class LinkPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return null !== $user;
    }

    public function view(User $user, Link $link)
    {
        return $user->id === $link->user_id;
    }

    public function create(User $user)
    {
        return $user->can(PermissionsType::create_links()->value);
    }

    public function edit(User $user, Link $link)
    {
        return $this->update($user, $link);
    }

    public function update(User $user, Link $link)
    {
        return $user->id === $link->user_id &&
            $user->can(PermissionsType::edit_links()->value) &&
            $link->status->notOneOfTheFollowing(LinkStatusType::waiting_approval());
    }

    public function delete(User $user, Link $link)
    {
        return $user->id === $link->user_id &&
            $link->status->notOneOfTheFollowing(LinkStatusType::waiting_approval());
    }

    public function restore(User $user, Link $link)
    {
        return $user->id === $link->user_id &&
            null === $link->deleted_at;
    }

    public function forceDelete(User $user, Link $link)
    {
        return $user->id === $link->user_id &&
            false === $link->deleted_at;
    }
}
