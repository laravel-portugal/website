<?php

namespace App\Helpers;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLikes
{
    /**
     * @return Collection
     */
    public function getLikes()
    {
        return $this->likes;
    }

    protected static function bootHasLikes()
    {
        static::deleting(function ($model) {
            /* @var static $model */
            $model->likes()->delete();
            $model->unsetRelation('likesRelation');
        });
    }

    public function likedBy(User $user)
    {
        $this->likes()->create(['user_id' => $user->id]);
        $this->unsetRelation('likes');
    }

    public function dislikedBy(User $user)
    {
        optional($this->likes()->where('user_id', $user->id)->first())->delete();
        $this->unsetRelation('likes');
    }

    /**
     * It's important to name the relationship the same as the method because otherwise
     * eager loading of the polymorphic relationship will fail on queued jobs.
     *
     * @see https://github.com/laravelio/laravel.io/issues/350
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
