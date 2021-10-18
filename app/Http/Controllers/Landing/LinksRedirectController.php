<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;
use function redirect;

class LinksRedirectController extends Controller
{
    public function redirect(Request $request, Link $link)
    {
        $link->incrementHit();

        return redirect()->away($link->url);
    }
}
