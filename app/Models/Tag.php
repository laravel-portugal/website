<?php

namespace App\Models;

use App\Concerns\HasSlug;
use App\Types\TagColorType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperTag
 */
final class Tag extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $casts = [
        'color' => TagColorType::class,
    ];

    public function links(): MorphToMany
    {
        return $this->morphedByMany(Link::class, 'taggable');
    }
}
