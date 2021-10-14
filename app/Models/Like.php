<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin IdeHelperLike
 */
final class Like extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function model(): MorphOne
    {
        return $this->morphOne(Link::class, 'taggable');
    }
}
