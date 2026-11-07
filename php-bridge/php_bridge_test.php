<?php
declare(strict_types=1);
require_once __DIR__ . '/worksai-linkengine-wp-bridge.php';
use WorksAi\LinkEngine\EdgeShortlinkBridge;

$res = EdgeShortlinkBridge::resolveLocal([
    'targetUrl' => 'https://worksai.org/apps/worksai-linkengine',
    'fallbackUrl' => 'https://worksai.org/apps',
    'healthy' => true,
    'utmSource' => 'wordpress',
    'utmMedium' => 'plugin',
    'utmCampaign' => 'ci_verify'
], ['userAgent' => 'Mozilla/5.0']);

assert(str_contains($res['resolvedUrl'], 'utm_source=wordpress'), 'Expected UTM source in resolved URL');
assert($res['countedHumanClick'] === true, 'Expected human click to be counted');

$blocked = false;
try {
    EdgeShortlinkBridge::resolveLocal(['targetUrl' => 'http://169.254.169.254/latest/meta-data']);
} catch (\InvalidArgumentException $e) {
    $blocked = true;
}
assert($blocked === true, 'Expected SSRF metadata IP to be rejected');
echo "LinkEngine PHP bridge tests passed.\n";
