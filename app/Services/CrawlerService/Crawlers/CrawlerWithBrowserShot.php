<?php

namespace App\Services\CrawlerService\Crawlers;

use App\Services\CrawlerService\CrawlerResponse;
use Spatie\Browsershot\Browsershot;

class CrawlerWithBrowserShot extends AbstractCrawler
{
    public function request(string $url, bool $deep = false): CrawlerResponse
    {
        $browserShot = Browsershot::url($url)
            ->ignoreHttpsErrors()
            ->dismissDialogs()
            ->addChromiumArguments(config('laravel-portugal.browserShot.args'))
            ->setNodeBinary(config('laravel-portugal.browserShot.options.node_binary'))
            ->setNpmBinary(config('laravel-portugal.browserShot.options.npm_binary'))
            ->userAgent(config('laravel-portugal.crawler.user-agent'))
            ->setScreenshotType(
                config('laravel-portugal.links.cover_image.format'),
                config('laravel-portugal.links.cover_image.quality'),
            )
            ->windowSize(
                config('laravel-portugal.links.cover_image.size.w'),
                config('laravel-portugal.links.cover_image.size.h'),
            );

        $screenshot = $browserShot->base64Screenshot();

        // No screenshot friends, lets keep going
        if (null === $screenshot) {
            return new CrawlerResponse($this);
        }

        $this->fromRawToDataURL($screenshot);

        // TODO: Ensure we can also pull the title and description on same run
        // I have checked the docs but no clue about this one.
        if ($deep) {
            $this->fromHTMLtoAttributes($browserShot->bodyHtml());
        }

        return new CrawlerResponse($this);
    }

    public function didCrawl(): bool
    {
        return ! empty($this->imageDataURL);
    }
}
