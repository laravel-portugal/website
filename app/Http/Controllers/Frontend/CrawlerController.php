<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CrawlerService\CrawlerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CrawlerController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        if (! $request->input('url')) {
            return response()->json([], 400);
        }

        try {
            return response()->json(
                (new CrawlerService())->url($request->input('url'))->execute()
            );
        } catch (\Exception $e) {
            logger($e);
        }

        return response()->json([], 400);
    }
}
