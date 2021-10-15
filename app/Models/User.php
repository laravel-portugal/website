<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use HasPermissions;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
        'name_letters',
    ];

    protected function defaultProfilePhotoUrl(): ?string
    {
        return null;
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function getNameLettersAttribute(): string
    {
        return $this->name ? get_name_first_words($this->name) : 'NA';
    }

    public function toInertiaShare(): array
    {
        return [
            'id' => $this->id,
            'name_letters' => get_name_first_words($this->name),
            'name' => $this->name,
            'email' => $this->email,
            'profile_photo_path' => $this->profile_photo_path,
            'profile_photo_url' => $this->profile_photo_url,
            'two_factor_enabled' => ! is_null($this->two_factor_secret),
            'roles' => $this->roles->pluck('name'),
            'permissions' => $this->getPermissionsViaRoles()->pluck('name'),
        ];
    }
}
