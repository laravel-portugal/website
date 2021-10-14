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

//    public function edit(Request $request, Link $link): Response
//    {
//        return Inertia::render('Links/Edit', [
//            'link' => $link->loadMissing('tags'),
//            'tags' => Tag::query()->take(10)->get(),
//        ]);
//    }
//
//    public function update(UpdateLinkRequest $request, Link $link): RedirectResponse
//    {
//        LinkUpdateAction::execute(
//            $link,
//            LinkUpdateDataDTO::fromRequest($request)
//        );
//
//        return redirect()->route('links.index');
//    }
//
//    public function destroy(Link $link): RedirectResponse
//    {
//        $link->delete();
//
//        return redirect()->route('links.index');
//    }
}
