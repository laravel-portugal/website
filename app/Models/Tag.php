<?php

namespace App\Models;

use App\Helpers\HasSlug;
use App\Types\TagColorType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @mixin IdeHelperTag
 */
final class Tag extends Model
{
    use HasFactory;
    use HasSlug;

    protected $casts = [
        'color' => TagColorType::class,
    ];

    public function links(): MorphToMany
    {
        return $this->morphedByMany(Link::class, 'taggable');
    }
}
