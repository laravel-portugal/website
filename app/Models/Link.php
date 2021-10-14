<?php

namespace App\Models;

use App\Concerns\HasAuthor;
use App\Concerns\HasLikes;
use App\Concerns\HasSearch;
use App\Concerns\HasTags;
use App\QueryBuilders\LinkQueryBuilder;
use App\Types\LinkStatusType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use JetBrains\PhpStorm\Pure;

/**
 * @mixin IdeHelperLink
 */
final class Link extends Model
{
    use HasFactory;
    use HasTags;
    use HasLikes;
    use HasAuthor;
    use HasSearch;
    use SoftDeletes;

    protected $casts = [
        'status' => LinkStatusType::class,
        'approved_at' => 'date',
        'rejected_at' => 'date'
    ];

    protected $fillable = [
        'url',
        'title',
        'description',
    ];

    protected $appends = [
        'cover_image_url',
        'title_preview',
        'description_preview',
        'created_at_for_humans',
        'updated_at_for_humans',
        'deleted_at_for_humans',
        'approved_at_for_humans',
        'redirect_url',
    ];

    protected array $searchable = [
        'columns' => [
            'links.title' => 1,
            'links.description' => 2,
            'links.status' => 3,
            'users.name' => 4,
            'users.email' => 5,
        ],
        'joins' => [
            'users' => ['users.id','links.user_id']
        ],
    ];

    #[Pure]
    public function newEloquentBuilder($query): LinkQueryBuilder
    {
        return new LinkQueryBuilder($query);
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->cover_image ? \Storage::disk(Link::coverPhotosDisk())->url($this->cover_image) : null;
    }

    public function getTitlePreviewAttribute(): string
    {
        return \Str::limit($this->title, 60) ?? '';
    }

    public function getDescriptionPreviewAttribute(): string
    {
        return \Str::limit($this->description, 60) ?? '';
    }

    public function getCreatedAtForHumansAttribute(): ?string
    {
        return $this?->created_at?->diffForHumans();
    }

    public function getUpdatedAtForHumansAttribute(): ?string
    {
        return $this?->updated_at?->diffForHumans();
    }

    public function getDeletedAtForHumansAttribute(): ?string
    {
        return $this?->deleted_at?->diffForHumans();
    }

    public function getApprovedAtForHumansAttribute(): ?string
    {
        return $this?->approved_at?->diffForHumans();
    }

    public function getRedirectUrlAttribute(): ?string
    {
        return $this->url ? route('links.redirect', $this) : '';
    }

    public static function coverPhotosDisk(): string
    {
        return config('laravel-portugal.links.storage.disk');
    }

    public static function coverPhotosFolder(): string
    {
        return config('laravel-portugal.links.storage.path');
    }

    public function incrementHit(bool $save = true): Link
    {
        $this->increment('hits');
        $save && $this->save();

        return $this;
    }
}
