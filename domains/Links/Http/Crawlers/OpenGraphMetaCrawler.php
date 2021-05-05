<?php

namespace Domains\Links\Http\Crawlers;

use DOMDocument;
use DOMXPath;
use Illuminate\Support\Str;

class OpenGraphMetaCrawler
{
    protected $content = null;
    protected $doc = null;
    protected $xPath = null;

    public function crawl($link)
    {
        $this->content = @file_get_contents($link);

        if (!$this->content) {
            return $this;
        }

        $this->doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $this->doc->loadHTML($this->content);
        libxml_clear_errors();

        $this->xPath = new DOMXPath($this->doc);

        return $this;
    }

    public function getOGImage()
    {
        if (!$this->xPath) {
            return null;
        }

        $imgUrl = optional($this->xPath->query('//head/meta[@property="og:image"]/@content')[0])
            ->value;

        if (!$imgUrl) {
            return null;
        }

        return Str::startsWith($imgUrl, '/')
            ? 'http://' . trim($imgUrl, '/')
            : $imgUrl;
    }
}
