<?php

namespace App\Services\CrawlerService\Crawlers;

use App\Services\CrawlerService\CrawlerResponse;

class CrawlerWithHttp extends AbstractCrawler
{
    protected ?string $content = null;

    public function request(string $url): CrawlerResponse
    {
        // Otherwise, perform the request and remember then setup
        $this->content = \Http::withHeaders([
            'Cache-Control: no-cache',
            sprintf('User-Agent: %s', config('laravel-portugal.crawler.user-agent')),
        ])
        ->withoutVerifying()
        ->withOptions([
            'allow_redirects' => [
                'max' => 5,
            ],
        ])
        ->get($url)
        ->body();

        $this->setup();

        return new CrawlerResponse($this);
    }

    protected function setup(): static
    {
        // No content at all, return
        if (! $this->content) {
            return $this;
        }

        // Parse the body and fill in
        $this->fromHTMLtoAttributes($this->content);

        // Pull the image from URL and transform it into attributes
        if (! empty($this->imageUrl)) {
            if ($imageRaw = file_get_contents($this->imageUrl)) {
                // Pass it to Intervention
                $this->fromRawToDataURL($imageRaw);
            }
        }

        // Ensure if we get a javascript disable warning to unset some failed stuff
        if (! empty($this->description) && \Str::contains($this->description, ['JavaScript', 'disable'])) {
            $this->description = null;
            $this->title = null;
        }

        return $this;
    }

    public function didCrawl(): bool
    {
        return ! empty($this->title);
    }
}
