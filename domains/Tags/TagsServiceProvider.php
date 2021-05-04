<?php

namespace Domains\Tags;

use App\Providers\BaseServiceProvider;

class TagsServiceProvider extends BaseServiceProvider
{
    public static function getName(): string
    {
        return 'tags';
    }
}
