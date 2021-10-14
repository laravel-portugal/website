<?php

namespace App\Services\CrawlerService;

use Arr;
use Illuminate\Support\Facades\Cache;
use JetBrains\PhpStorm\Pure;

class CrawlerService
{
    protected bool $cached = true;
    protected ?string $url;

    public function __construct(?string $url = null, bool $cached = true)
    {
        $this->url = $url;
        $this->cached = $cached;
    }

    /**
     * @throws \Exception
     */
    public function execute(): array
    {
        if (null === $this->url) {
            throw new \Exception('Crawler Service. URL cannot be empty');
        }

        if ($this->cached && Cache::has($this->getCacheKey())) {
            return Cache::get($this->getCacheKey());
        }

        $payload = $this->_execute();
        // Ensure we only save to cache in case there is a image
        if (! empty($payload) && null !== Arr::get($payload, 'image_data_url')) {
            Cache::remember(
                $this->getCacheKey(),
                now()->addHours(),
                fn () => $payload
            );
        }

        return $payload;
    }

    protected function _execute(): array
    {
        try {
            // Removes Trailing Slash
            $this->url = rtrim($this->url, '/');

            if (! is_valid_url_to_call_internally($this->url)) {
                return [];
            }

            // Attempt to get via HTTP request
            $httpCrawl = (new Crawlers\CrawlerWithHttp())->request($this->url);

            // If no image was returned, then attempt with browser shot
            if (! $httpCrawl->didCrawl() || null === $httpCrawl->crawler()->getImageUrl()) {
                // Ensure deepness if the HTTP crawler failed to due to requiring javascript
                // Warning: Keep in mind this costs 2 round trips to the website, ideally it would be
                // good if we can keep it one.
                $deepWhen = empty($httpCrawl->crawler()->getTitle(false)) || empty($httpCrawl->crawler()->getDescription());

                // Launch the Browser Shot
                $browserShotCrawl = (new Crawlers\CrawlerWithBrowserShot())->request($this->url, $deepWhen);

                // Merge both
                return $httpCrawl
                    ->toCollection()
                    ->merge($browserShotCrawl->toCollection()->filter(fn ($value) => ! empty($value)))
                    ->toArray();
            }

            return $httpCrawl->toArray();
        } catch (\Exception $e) {
            ray($e);
            logger($e->getMessage(), [
                'trace' => $e->getTrace(),
                'trace_string' => $e->getTraceAsString(),
            ]);
        }

        return [];
    }

    public function url(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function cached(): self
    {
        $this->cached = true;

        return $this;
    }

    public function withoutCache(): self
    {
        $this->cached = false;

        return $this;
    }

    #[Pure]
    protected function getCacheKey(): string
    {
        return tokenize('crawler', $this->url);
    }
}
