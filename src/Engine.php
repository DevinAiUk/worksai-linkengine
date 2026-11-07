<?php
declare(strict_types=1);

/**
 * WorksAi LinkEngine (worksai-10)
 * Upstream Origin: Shlink (https://github.com/shlinkio/shlink @ 9008811)
 * License: MIT License
 * Copyright (c) 2016-2026 Alejandro Celaya
 * Copyright (c) 2026 WorksAi.org (InstaOnPc LLC)
 */

namespace WorksAi\WorksAiLinkEngine;

final class Engine
{
    public const PRODUCT_ID = 'worksai-10';
    public const VERSION = '1.0.0';
    public const UPSTREAM_COMMIT = '9008811';

    /**
     * Sanitizes text fragments before rendering HTML or JSON-LD blocks.
     */
    public static function sanitize(string $input): string
    {
        $stripped = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $input) ?? '';
        return htmlspecialchars($stripped, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /**
     * Validates that a redirect or webhook destination URL is HTTPS/HTTP and not a private/loopback IP.
     */
    public static function isSafeDestinationUrl(string $url): bool
    {
        $parts = parse_url($url);
        if (!is_array($parts) || empty($parts['scheme']) || empty($parts['host'])) {
            return false;
        }
        $scheme = strtolower((string) $parts['scheme']);
        if (!in_array($scheme, ['https', 'http'], true)) {
            return false;
        }
        $host = strtolower((string) $parts['host']);
        if (in_array($host, ['localhost', '127.0.0.1', '0.0.0.0', '169.254.169.254'], true)) {
            return false;
        }
        return true;
    }
}
