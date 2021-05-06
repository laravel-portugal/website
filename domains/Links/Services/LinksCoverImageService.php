<?php

namespace Domains\Links\Services;

use Domains\Links\Http\Crawlers\OpenGraphMetaCrawler;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class LinksCoverImageService
{
    protected OpenGraphMetaCrawler $crawler;
    protected array $config;
    protected string $link;

    public function __construct()
    {
        $this->config = config('laravel-portugal.links');
        $this->crawler = new OpenGraphMetaCrawler();
    }

    public function forLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function __invoke(): ?string
    {
        return $this->getOGImage($this->link) ?? $this->getBrowserShotImage($this->link);
    }

    protected function getOGImage(string $link): ?string
    {
        $img = $this->crawler
            ->crawl($link)
            ->getOGImage();

        if (!$img) {
            return null;
        }

        $targetFile = $this->config['storage']['path'] . '/' . uniqid('', true) . '.' . $this->config['cover_image']['format'];
        $targetPath = Storage::disk('public')->path($targetFile);
        try {
            Storage::disk('public')->makeDirectory($this->config['storage']['path']);
            Storage::disk('public')->put($targetPath, file_get_contents($img));

            return $targetFile;
        } catch (\Exception) {
            return null;
        }
    }

    protected function getBrowserShotImage($link): ?string
    {
        $targetFile = $this->config['storage']['path'] . '/' . uniqid('', true) . '.' . $this->config['cover_image']['format'];
        $targetPath = Storage::disk('public')->path($targetFile);

        try {
            Storage::disk('public')
                ->makeDirectory($this->config['storage']['path']);

            Browsershot::url($link)
                ->dismissDialogs()
                ->ignoreHttpsErrors()
                ->setScreenshotType(
                    $this->config['cover_image']['format'],
                    $this->config['cover_image']['quality']
                )
                ->windowSize(
                    $this->config['cover_image']['size']['w'],
                    $this->config['cover_image']['size']['h']
                )
                ->save($targetPath);

            return $targetFile;
        } catch (\Exception) {
            return null;
        }
    }
}
