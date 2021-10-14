<?php

namespace App\Helpers;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * @param \App\Models\Tag[]|int[] $tags
     */
    public function syncTags(array $tags, bool $save = true)
    {
        $save && $this->save();
        $this->tags()->sync($tags);
        $this->unsetRelation('tags');
    }

    public function removeTags()
    {
        $this->tags()->detach();

        $this->unsetRelation('tags');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }
}
