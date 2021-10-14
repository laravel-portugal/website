<?php

namespace App\Types;

/**
 * @method static self red()
 * @method static self blue()
 * @method static self purple()
 * @method static self yellow()
 * @method static self indigo()
 * @method static self pink()
 * @method static self gray()
 * @method static self primary()
 */
final class TagColorType extends BaseType
{
    protected static function values(): array
    {
        return [
            'red' => 'red',
            'blue' => 'blue',
            'purple' => 'purple',
            'yellow' => 'yellow',
            'indigo' => 'indigo',
            'pink' => 'pink',
            'gray' => 'gray',
            'primary' => 'primary',
        ];
    }

    protected static function labels(): array
    {
        return [
            'red' => 'red',
            'blue' => 'blue',
            'purple' => 'purple',
            'yellow' => 'yellow',
            'indigo' => 'indigo',
            'pink' => 'pink',
            'gray' => 'gray',
            'primary' => 'primary',
        ];
    }
}
