<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;

class LinksRedirectController extends Controller
{
    public function redirect(Request $request, Link $link)
    {
        $link->incrementHit();

        return \redirect()->away($link->url);
    }
}
