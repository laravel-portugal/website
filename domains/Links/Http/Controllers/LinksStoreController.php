<?php

namespace Domains\Links\Http\Controllers;

use App\Http\Controllers\Controller;
use Domains\Links\DTOs\LinksStoreDTO;
use Domains\Links\Http\Requests\LinksStoreRequest;
use Domains\Links\Services\LinksStoreService;
use Illuminate\Http\Response;

class LinksStoreController extends Controller
{
    public function __invoke(LinksStoreRequest $request): Response
    {
        app(LinksStoreService::class)
            ->__invoke(
                new LinksStoreDTO([
                    ...($request->input()),
                    'cover_image' => $request->file('cover_image')->store('cover_images', 'public'),
                ])
            );

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
