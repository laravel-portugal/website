<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperUserSocialAccount
 */
final class UserSocialAccount extends Model
{
    protected $fillable = [
        'provider_user_id',
        'provider',
        'data',
        'user_id',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function getMorphClass(): string
    {
        return 'user_social_account';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
