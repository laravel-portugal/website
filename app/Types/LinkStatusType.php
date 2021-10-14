<?php

namespace App\Types;

/**
 * @method static self published()
 * @method static self rejected()
 * @method static self waiting_approval()
 */
final class LinkStatusType extends BaseType
{
    protected static function values(): array
    {
        return [
            'published' => 'published',
            'rejected' => 'rejected',
            'waiting_approval' => 'waiting_approval',
        ];
    }

    protected static function labels(): array
    {
        return [
            'published' => trans('app.link_status.published'),
            'rejected' => trans('app.link_status.rejected'),
            'waiting_approval' => trans('app.link_status.waiting_approval'),
        ];
    }
}
