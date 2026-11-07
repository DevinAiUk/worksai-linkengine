<?php
/**
 * Plugin Name:       WorksAi LinkEngine Companion Bridge
 * Plugin URI:        https://devinai.uk/worksai/products/worksai-linkengine/
 * Description:       MIT-licensed PHP URL shortener, UTM campaign builder, and WordPress bridge with link-rot detection. (MIT-licensed derivative of Shlink @ 9008811).
 * Version:           1.0.0
 * Requires at least: 6.4
 * Requires PHP:      8.2
 * Author:            WorksAi.org
 * Author URI:        https://worksai.org
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/src/Engine.php';
