<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LinksController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Frontend/Links/Index', [
            'links' => Link::query()
                ->published()
                ->applySearchAndSmartFilterRestricted($request)
                ->with('author', 'tags')
                ->latest()
                ->paginate(),
        ]);
    }
}
