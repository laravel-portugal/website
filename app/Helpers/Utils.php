<?php

if (! function_exists('url_to_upload_file')) {
    /**
     * Takes an external URL and transforms it into a UploadedFile.
     */
    function url_to_upload_file(string $url): Illuminate\Http\UploadedFile
    {
        $info = pathinfo($url);
        $contents = file_get_contents($url);
        $file = '/tmp/'.$info['basename'];
        file_put_contents($file, $contents);

        return new Illuminate\Http\UploadedFile($file, $info['basename']);
    }
}

if (! function_exists('get_name_first_words')) {
    function get_name_first_words(string $name): string
    {
        $acronym = '';
        $words = preg_split("/[\s,_-]+/", $name, 2);

        if (empty(array_filter($words))) {
            return $name;
        }

        foreach ($words as $w) {
            $acronym .= $w[0];
        }

        return $acronym;
    }
}

if (! function_exists('trans_values')) {
    /**
     * Translate array values.
     */
    function trans_values(array $array = [], string $prefix = ''): array
    {
        $out = [];
        foreach ($array as $key => $value) {
            if (! empty($key)) {
                $out[$key] = trans($prefix.$value);
            } else {
                $out[$key] = $value;
            }
        }

        return $out;
    }
}

if (! function_exists('trans_keys')) {
    /**
     * Translate array keys.
     */
    function trans_keys(array $array = [], string $prefix = ''): array
    {
        $out = [];
        foreach ($array as $key => $value) {
            $out[trans($prefix.$key)] = $value;
        }

        return $out;
    }
}

if (! function_exists('tokenize')) {
    /**
     * Tokenize an array of multiple arguments into a string.
     */
    function tokenize(...$args): string
    {
        return implode('_', $args);
    }
}

if (! function_exists('is_valid_url_to_call_internally')) {
    /**
     * Thanks to robert for pointing out, we should make sure no internal URLS/IPS can be called.
     * Prevents a bit SSFR but still WIP, this needs to be well done.
     * Note/WARNING : trusted hosts on this machine network can be still resolve valid urls, this can
     * expose issues when the user is intentionally calling external URLS to discover services.
     *
     * Ex: https://site.test/craw/?url=https://local_secure_service.mynetwork would still resolve.
     *
     * @see https://www.youtube.com/watch?v=RCJdPiogUIk
     */
    function is_valid_url_to_call_internally(string $url): bool
    {
        if (
            Str::contains($url, 'localhost') ||
            Str::contains($url, '127.0.0.1') ||
            Str::contains($url, '::1')
        ) {
            return false;
        }

        if (false === filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        // Resolve the host to IP Address
        $hostIpAddress = Arr::get(gethostbynamel(Str::replace(['www.', 'www', 'ww3'], '', parse_url($url, PHP_URL_HOST))), 0);
        if (null === $hostIpAddress) {
            return false;
        }

        return filter_var($hostIpAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }
}

if (! function_exists('hash_url')) {
    /**
     * Cleanup query string from url.
     */
    function hash_url($str): string
    {
        return md5(strtok($str, '?'));
    }
}
