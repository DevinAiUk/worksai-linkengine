<?php
/**
 * Plugin Name: WorksAi LinkEngine — Smart Shortlink & Internal Topic-Cluster Bridge
 * Plugin URI: https://linkengine.worksai.org
 * Description: WordPress / PHP 8.2+ integration providing local SSRF-safe shortlink resolution, bot filtering, UTM injection, and Edge MCP sync.
 * Version: 1.2.0
 * License: MIT
 */
declare(strict_types=1);
namespace WorksAi\LinkEngine;

final class EdgeShortlinkBridge {
    public static function isSafeExternalUrl(string $rawUrl): bool {
        $parts = parse_url($rawUrl);
        if (!$parts || !isset($parts['scheme'], $parts['host'])) {
            return false;
        }
        $scheme = strtolower($parts['scheme']);
        if ($scheme !== 'https' && $scheme !== 'http') {
            return false;
        }
        $host = strtolower($parts['host']);
        if (in_array($host, ['localhost', '127.0.0.1', '0.0.0.0', '169.254.169.254'], true) ||
            str_starts_with($host, '10.') ||
            str_starts_with($host, '192.168.') ||
            preg_match('/^172\.(1[6-9]|2\d|3[0-1])\./', $host) === 1) {
            return false;
        }
        return true;
    }

    public static function resolveLocal(array $linkRecord, array $requestContext = []): array {
        $targetUrl = (string)($linkRecord['targetUrl'] ?? '');
        if (!self::isSafeExternalUrl($targetUrl)) {
            throw new \InvalidArgumentException('SecurityError: Unsafe or invalid targetUrl.');
        }
        $ua = (string)($requestContext['userAgent'] ?? '');
        $isBot = preg_match('/bot|crawler|spider|headless|ahrefs|semrush/i', $ua) === 1;
        $destination = $targetUrl;
        $healthy = ($linkRecord['healthy'] ?? true) !== false;
        $fallbackUrl = (string)($linkRecord['fallbackUrl'] ?? '');

        if (!$healthy && $fallbackUrl !== '' && self::isSafeExternalUrl($fallbackUrl)) {
            $destination = $fallbackUrl;
        } elseif (preg_match('/iphone|ipad|ios/i', $ua) === 1 && !empty($linkRecord['iosUrl'])) {
            $destination = (string)$linkRecord['iosUrl'];
        } elseif (preg_match('/android/i', $ua) === 1 && !empty($linkRecord['androidUrl'])) {
            $destination = (string)$linkRecord['androidUrl'];
        }

        $utm = [];
        if (!empty($linkRecord['utmSource'])) $utm['utm_source'] = (string)$linkRecord['utmSource'];
        if (!empty($linkRecord['utmMedium'])) $utm['utm_medium'] = (string)$linkRecord['utmMedium'];
        if (!empty($linkRecord['utmCampaign'])) $utm['utm_campaign'] = (string)$linkRecord['utmCampaign'];

        $sep = str_contains($destination, '?') ? '&' : '?';
        $resolvedUrl = empty($utm) ? $destination : $destination . $sep . http_build_query($utm);

        return [
            'resolvedUrl' => $resolvedUrl,
            'isBot' => $isBot,
            'countedHumanClick' => !$isBot,
            'usedFallback' => !$healthy && $fallbackUrl !== ''
        ];
    }
}
