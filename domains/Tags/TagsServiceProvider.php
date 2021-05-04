<?php

namespace Domains\Tags;

use Domains\Support\BaseServiceProvider;

class TagsServiceProvider extends BaseServiceProvider
{
    public static function getName(): string
    {
        return 'tags';
    }
}
