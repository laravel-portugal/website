<?php

namespace App\Services\CrawlerService\Crawlers;

use App\Services\CrawlerService\Concerns\CrawlerInterface;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

abstract class AbstractCrawler implements CrawlerInterface
{
    protected ?string $imageUrl = null;
    protected ?string $imageWidth = null;
    protected ?string $imageHeight = null;
    protected ?string $imageMime = null;
    protected ?string $imageBlob = null;
    protected ?string $imageDataURL = null;

    protected ?string $title = null;
    protected ?string $siteName = null;
    protected ?string $description = null;
    protected ?string $url = null;
    protected ?string $type = null;

    protected function fromRawToDataURL(string $rawImage): static
    {
        try {
            $image = \Image::make($rawImage);

            // Fit
            $image->fit(
                config('laravel-portugal.links.cover_image.size.w'),
                config('laravel-portugal.links.cover_image.size.h')
            );

            // Encode
            $image->encode('data-url');

            // Assign info
            $this->imageBlob = $image->getEncoded();
            $this->imageDataURL = $image->getEncoded();
            $this->imageHeight = $image->height();
            $this->imageWidth = $image->width();
            $this->imageMime = $image->mime();
        } catch (\Exception $e) {
        }

        return $this;
    }

    protected function fromHTMLtoAttributes($rawHtml)
    {
        $document = new \DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML($rawHtml);
        libxml_clear_errors();
        $xpath = new \DOMXPath($document);

        // Image Url
        $this->imageUrl =
            $xpath->query('//head/meta[@property="og:image"]/@content')[0]?->value ??
            $xpath->query('//head/meta[@property="og:image:secure_url"]/@content')[0]?->value ??
            $xpath->query('//head/meta[@property="twitter:image"]/@content')[0]?->value ??
            $xpath->query('//head/meta[@property="twitter:image:secure_url"]/@content')[0]?->value;

        // Grab the title
        $this->title =
            $xpath->query('//head/meta[@property="og:title"]/@content')[0]?->value ??
            $xpath->query('//head/meta[@property="twitter:title"]/@content')[0]?->value ??
            $xpath->query('//title')?->item(0)?->textContent;

        // Grab the site name
        $this->siteName = $xpath->query('//head/meta[@property="og:site_name"]/@content')[0]?->value ?? null;

        // Grab the description
        $this->description =
            $xpath->query('//head/meta[@property="og:description"]/@content')[0]?->value ??
            $xpath->query('//head/meta[@property="twitter:description"]/@content')[0]?->value ??
            // Closest Paragraph after h1 tag and on-going h tags
            $xpath->query('//h1/following::p[1]')[0]?->nodeValue ??
            $xpath->query('//h2/following::p[1]')[0]?->nodeValue ??
            $xpath->query('//h3/following::p[1]')[0]?->nodeValue ??
            $xpath->query('//h4/following::p[1]')[0]?->nodeValue;

        // Type
        $this->type = $xpath->query('//head/meta[@property="og:type"]/@content')[0]?->value ?? 'website';

        // Url
        $this->url = $xpath->query('//head/meta[@property="og:url"]/@content')[0]?->value;
    }

    #[Pure]
    public function getImageUrl(): ?string
    {
        return Str::startsWith($this->imageUrl, '/') ? 'https://'.trim($this->imageUrl, '/') : $this->imageUrl;
    }

    public function getTitle($withSiteName = true, $separator = '|'): ?string
    {
        return $withSiteName && ! empty($this->siteName) ? sprintf('%s %s %s', $this->title, $separator, $this->siteName) : $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getImageDataUrl(): ?string
    {
        return $this->imageDataURL;
    }

    public function getImageBlob(): ?string
    {
        return $this->imageDataURL;
    }

    public function getImageHeight(): ?string
    {
        return $this->imageHeight;
    }

    public function getImageWidth(): ?string
    {
        return $this->imageWidth;
    }

    public function getImageMimeType(): ?string
    {
        return $this->imageMime;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }
}
