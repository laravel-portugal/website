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
            'red' => trans('app.tag_colors.red'),
            'blue' => trans('app.tag_colors.blue'),
            'purple' => trans('app.tag_colors.purple'),
            'yellow' => trans('app.tag_colors.yellow'),
            'indigo' => trans('app.tag_colors.indigo'),
            'pink' => trans('app.tag_colors.pink'),
            'gray' => trans('app.tag_colors.gray'),
            'primary' => trans('app.tag_colors.primary'),
        ];
    }
}
