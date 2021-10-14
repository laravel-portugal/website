<?php

namespace App\Services\CrawlerService;

use App\Services\CrawlerService\Concerns\CrawlerInterface;
use App\Services\CrawlerService\Crawlers\AbstractCrawler;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

class CrawlerResponse
{
    protected CrawlerInterface|AbstractCrawler $crawler;

    public function __construct(AbstractCrawler $crawler)
    {
        $this->crawler = $crawler;
    }

    public function toArray(): array
    {
        return array_filter([
            'success' => $this->crawler->didCrawl(),
            'title' => \Str::limit($this->cleanupString($this->crawler->getTitle()), config('laravel-portugal.links.title_max_size'), ''),
            'description' => \Str::limit($this->cleanupString($this->crawler->getDescription()), config('laravel-portugal.links.description_max_size', '')),
            'type' => $this->crawler->getType(),
            'url' => $this->crawler->getUrl(),
            // Image Attributes
            'image_url' => $this->crawler->getImageUrl(),
            'image_data_url' => $this->crawler->getImageDataUrl(),
            'image_width' => $this->crawler->getImageWidth(),
            'image_height' => $this->crawler->getImageHeight(),
            'image_mime' => $this->crawler->getImageMimeType(),
        ]);
    }

    public function didCrawl(): bool
    {
        return $this->crawler->didCrawl();
    }

    public function crawler(): AbstractCrawler
    {
        return $this->crawler;
    }

    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }

    protected function cleanupString(?string $string)
    {
        if (null === $string) {
            return null;
        }

        return app(Pipeline::class)
            ->send($string)
            ->through(
                fn ($passable, $next) => $next(strip_tags($passable)),
                fn ($passable, $next) => $next(strip_tags($passable)),
                fn ($passable, $next) => $next(preg_replace("/\r|\n/", '', $passable)),
                fn ($passable, $next) => $next(preg_replace('/\s+/', ' ', $passable)),
                fn ($passable, $next) => $next(trim(rtrim($passable)))
            )
            ->thenReturn();
    }
}
