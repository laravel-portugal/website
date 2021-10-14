<?php

namespace App\Types;

/**
 * @method static self admin()
 * @method static self user()
 * @method static self moderator()
 */
final class RolesType extends BaseType
{
    protected static function values(): array
    {
        return [
            'admin' => 'admin',
            'user' => 'user',
            'moderator' => 'moderator',
        ];
    }

    protected static function labels(): array
    {
        return [
            'admin' => 'admin',
            'user' => 'user',
            'moderator' => 'moderator',
        ];
    }
}
