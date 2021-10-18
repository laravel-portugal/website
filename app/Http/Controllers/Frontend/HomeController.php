<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Frontend/Landing/Index', [
            'tags' => Tag::query()->take(20)->paginate(),
            'links' => Link::query()->with('author', 'tags')->take(8)->latest()->get(),
        ]);
    }
}
