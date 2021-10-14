<?php

namespace App\Observers;

use App\Models\Link;

class LinkObserver
{
    public function creating(Link $link)
    {
        // Hash the URL
        $link->url_hash = hash_url($link->url);
    }

    public function updating(Link $link)
    {
        // Re-Hash the URL
        if ($link->isDirty('url')) {
            $link->url_hash = hash_url($link->url);
        }
    }
}
