<?php

namespace Domains\Accounts;

use App\Providers\BaseServiceProvider;

class AccountsServiceProvider extends BaseServiceProvider
{
    public static function getName(): string
    {
        return 'accounts';
    }
}
