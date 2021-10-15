<?php

namespace App\Http\Middleware;

use App\Types\LinkStatusType;
use Breadcrumbs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     *
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'user' => optional($request->user())->toInertiaShare(),
            'authorization' => $this->shareAuthorizationErrors(),
            'guidelines' => $this->shareGuideLines(),
            'breadcrumbs' => $this->sharesPageBreadcrumbs(),
            'meta' => $this->shareMeta(),
        ]);
    }

    /**
     * Share Authorization Errors.
     */
    protected function shareMeta(): array
    {
        return [
            'site_name' => config('app.name'),
            'site_url' => config('app.url'),
            'locale' => config('app.locale'),
        ];
    }

    /**
     * Share Authorization Errors.
     */
    protected function shareGuideLines(): array
    {
        return [
            'links' => [
                'status' => LinkStatusType::toGuideLine(),
            ],
        ];
    }

    /**
     * Share Authorization Errors.
     */
    protected function shareAuthorizationErrors(): ?string
    {
        return session()->get('authorization') ?? null;
    }

    /**
     * Shares breadcrumbs.
     */
    protected function sharesPageBreadcrumbs(): array|Collection
    {
        try {
            return Breadcrumbs::generate();
        } catch (Exception $e) {
            return [];
        }
    }
}
