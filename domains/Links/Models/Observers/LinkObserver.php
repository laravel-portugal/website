<?php

namespace Domains\Links\Models\Observers;

use App\Models\User;
use Domains\Accounts\Enums\AccountTypeEnum;
use Domains\Links\Exceptions\UnapprovedLinkLimitReachedException;
use Domains\Links\Models\Link;
use Illuminate\Support\Facades\Auth;

class LinkObserver
{
    public function saving(Link $link): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user && ($user->isTrusted() || $user->hasRole(AccountTypeEnum::EDITOR))) {
            return true;
        }

        $pendingCount = Link::forAuthorWithEmail($link->author_email)
            ->unapproved()
            ->count();

        throw_unless($pendingCount < config('links.max_unapproved_links'), UnapprovedLinkLimitReachedException::class);

        return true;
    }
}
