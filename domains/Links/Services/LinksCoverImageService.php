<?php

namespace Domains\Links\Services;

use Domains\Links\Http\Crawlers\OpenGraphMetaCrawler;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class LinksCoverImageService
{
    protected OpenGraphMetaCrawler $crawler;
    protected array $linksConfig;
    protected array $browserShotConfig;
    protected string $link;

    public function __construct()
    {
        $this->linksConfig = config('laravel-portugal.links');
        $this->browserShotConfig = config('laravel-portugal.browserShot');
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

        $targetFile = $this->linksConfig['storage']['path'] . '/' . uniqid('', true) . '.' . $this->linksConfig['cover_image']['format'];
        try {
            Storage::disk('public')->makeDirectory($this->linksConfig['storage']['path']);
            Storage::disk('public')->put($targetFile, file_get_contents($img));

            return $targetFile;
        } catch (\Exception) {
            return null;
        }
    }

    protected function getBrowserShotImage($link): ?string
    {
        $targetFile = $this->linksConfig['storage']['path'] . '/' . uniqid('', true) . '.' . $this->linksConfig['cover_image']['format'];
        $targetPath = Storage::disk('public')->path($targetFile);

        try {
            Storage::disk('public')
                ->makeDirectory($this->linksConfig['storage']['path']);

            Browsershot::url($link)
                ->addChromiumArguments($this->browserShotConfig['args'])
                ->dismissDialogs()
                ->ignoreHttpsErrors()
                ->setScreenshotType(
                    $this->linksConfig['cover_image']['format'],
                    $this->linksConfig['cover_image']['quality']
                )
                ->windowSize(
                    $this->linksConfig['cover_image']['size']['w'],
                    $this->linksConfig['cover_image']['size']['h']
                )
                ->save($targetPath);

            return $targetFile;
        } catch (\Exception) {
            return null;
        }
    }
}
