<?php

namespace App\Services\CrawlerService\Concerns;

use App\Services\CrawlerService\CrawlerResponse;

interface CrawlerInterface
{
    public function request(string $url): CrawlerResponse;

    public function didCrawl(): bool;
}
