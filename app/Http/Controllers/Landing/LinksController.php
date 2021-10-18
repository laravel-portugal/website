<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LinksController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Links/Index', [
            'links' => $request
                ->user()
                ->links()
                ->with('author', 'tags')
                ->latest()
                ->paginate(),
        ]);
    }
}
