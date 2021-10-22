<?php

namespace App\Http\Controllers\Admin;

use App\Actions\LinkDeleteAction;
use App\Actions\LinkUpdateAction;
use App\DataTransferObjects\LinkUpdateDataDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateLinkRequestForAdmin;
use App\Models\Link;
use App\Models\Tag;
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
        return Inertia::render('Admin/Links/Index', [
            'links' => Link::query()
                ->with('author', 'tags')
                ->applySearchAndSmartFilter($request)
                ->withTrashed()
                ->latest('updated_at')
                ->paginate(10),
        ]);
    }

    public function edit(Request $request, Link $link): Response
    {
        return Inertia::render('Admin/Links/Edit', [
            'link' => $link->loadMissing('tags'),
            'tags' => Tag::query()->take(10)->get(),
        ]);
    }

    public function update(UpdateLinkRequestForAdmin $request, Link $link): RedirectResponse
    {
        LinkUpdateAction::execute($link, LinkUpdateDataDTO::fromRequest($request));

        return redirect()->route('admin.links.index');
    }

    public function destroy(Link $link): RedirectResponse
    {
        LinkDeleteAction::execute($link);

        return redirect()->route('admin.links.index');
    }

    public function destroyForce(Link $link): RedirectResponse
    {
        LinkDeleteAction::execute($link, true);

        return redirect()->route('admin.links.index');
    }

    public function restore(Link $link): RedirectResponse
    {
        $link->restore();

        return redirect()->route('admin.links.index');
    }

    public function markAs(Request $request, Link $link, $status): RedirectResponse
    {
        LinkUpdateAction::execute($link, LinkUpdateDataDTO::fromStatus($link, $status));

        return back();
    }
}
