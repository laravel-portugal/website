<?php

namespace Domains\Accounts;

use Domains\Support\BaseServiceProvider;

class AccountsServiceProvider extends BaseServiceProvider
{
    public static function getName(): string
    {
        return 'accounts';
    }
}
