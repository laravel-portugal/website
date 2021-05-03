<?php

namespace Domains\Links\Models\Observers;

use Domains\Accounts\Enums\AccountTypeEnum;
use Domains\Links\Models\Link;
use Illuminate\Support\Facades\Auth;

class LinkObserver
{
    public function saving(Link $link): bool
    {
        $user = Auth::user();
        if ($user && ($user->isTrusted() || $user->hasRole(AccountTypeEnum::EDITOR))) {
            return true;
        }

        $pendingCount = Link::forAuthorWithEmail($link->author_email)
            ->unapproved()
            ->count();

        return $pendingCount < config('links.max_unapproved_links');
    }
}
