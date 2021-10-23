<?php

namespace App\Http\Controllers\Admin;

use App\Actions\TagDeleteAction;
use App\Actions\TagStoreAction;
use App\Actions\TagUpdateAction;
use App\DataTransferObjects\TagStoreDataDTO;
use App\DataTransferObjects\TagUpdateDataDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminTagsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Tag::class, 'tag');
    }

    public function index(Request $request): Response
    {
        return Inertia::render('Admin/Tags/Index', [
            'tags' => Tag::query()
                ->withCount('links')
                ->withTrashed()
                ->latest('updated_at')
                ->paginate(10),
        ]);
    }

    public function create(Request $request): Response
    {
        return Inertia::render('Admin/Tags/Create', [
            'tag' => new Tag(),
        ]);
    }

    public function store(StoreTagRequest $request): RedirectResponse
    {
        TagStoreAction::execute(TagStoreDataDTO::fromRequest($request));

        return redirect()->route('admin.tags.index');
    }

    public function edit(Request $request, Tag $tag): Response
    {
        return Inertia::render('Admin/Tags/Edit', [
            'tag' => $tag,
        ]);
    }

    public function update(UpdateTagRequest $request, Tag $tag): RedirectResponse
    {
        TagUpdateAction::execute($tag, TagUpdateDataDTO::fromRequest($request));

        return redirect()->route('admin.tags.index');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        TagDeleteAction::execute($tag);

        return redirect()->route('admin.tags.index');
    }

    public function destroyForce(Tag $tag): RedirectResponse
    {
        TagDeleteAction::execute($tag, true);

        return redirect()->route('admin.tags.index');
    }

    public function restore(Tag $tag): RedirectResponse
    {
        $tag->restore();

        return redirect()->route('admin.tags.index');
    }
}
