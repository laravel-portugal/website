<?php

namespace App\Helpers\Extensions;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

class Paginator
{
    public static function register()
    {
        app()->bind(LengthAwarePaginator::class, function ($app, $values) {
            return new class(...array_values($values)) extends LengthAwarePaginator {
                protected $mergeWith;

                public function only(...$attributes)
                {
                    return $this->transform(function ($item) use ($attributes) {
                        return $item->only($attributes);
                    });
                }

                public function transform($callback)
                {
                    $this->items->transform($callback);

                    return $this;
                }

                public function with($array = [])
                {
                    $this->mergeWith = $array;

                    return $this;
                }

                public function toArray()
                {
                    return [
                        'data' => $this->items->toArray(),
                        'links' => [
                            'pages' => $this->links(),
                            'next' => $this->nextPageUrl(),
                            'previous' => $this->previousPageUrl(),
                        ],
                        'meta' => [
                            'to' => $this->lastItem(),
                            'from' => $this->firstItem(),
                            'total' => $this->total(),
                            'per_page' => $this->perPage(),
                            'current_page' => $this->currentPage(),
                        ],
                        'response' => $this->mergeWith ?? [],
                    ];
                }

                public function links($view = null, $data = [])
                {
                    $this->appends(Request::query()); // Only Query Items
                    $window = UrlWindow::make($this);

                    $elements = array_filter([
                        $window['first'],
                        is_array($window['slider']) ? '...' : null,
                        $window['slider'],
                        is_array($window['last']) ? '...' : null,
                        $window['last'],
                    ]);

                    return Collection::make($elements)->flatMap(function ($item) {
                        if (is_array($item)) {
                            return Collection::make($item)->map(fn ($url, $page) => [
                                'url' => $url,
                                'label' => $page,
                                'active' => $this->currentPage() === $page,
                            ]);
                        } else {
                            return [
                                [
                                    'url' => null,
                                    'label' => '...',
                                    'active' => false,
                                ],
                            ];
                        }
                    });
                }
            };
        });
    }
}
