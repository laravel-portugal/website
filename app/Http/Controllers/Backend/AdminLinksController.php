<?php

namespace App\Http\Controllers\Backend;

use App\Actions\LinkUpdateAction;
use App\DataTransferObjects\LinkUpdateDataDTO;
use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminLinksController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Link::class, 'link');
    }

    public function index(Request $request): Response
    {
        return Inertia::render('Backend/Links/Index', [
            'links' => Link::query()
                ->with('author', 'tags')
                ->applySearchAndSmartFilter($request)
                ->latest('updated_at')
                ->paginate(10),
        ]);
    }

    public function markAs(Request $request, Link $link, $status): RedirectResponse
    {
        LinkUpdateAction::execute($link, LinkUpdateDataDTO::fromStatus($link, $status));
        return back();
    }
}
