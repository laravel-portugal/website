<?php

namespace App\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAuthor
{
    public function getAuthor(): User
    {
        return $this->authorRelation;
    }

    public function authoredBy(User $author)
    {
        $this->authorRelation()->associate($author);

        $this->unsetRelation('authorRelation');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isAuthoredBy(User $user): bool
    {
        return $this->author()->is($user);
    }
}
