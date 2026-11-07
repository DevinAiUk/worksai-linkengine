# WorksAi LinkEngine (`worksai-10`)

> MIT-licensed PHP URL shortener, UTM campaign builder, and WordPress bridge with link-rot detection.

**Category:** D. WordPress/PHP products  
**License:** MIT (Derivative of [Shlink](https://github.com/shlinkio/shlink) @ `9008811`)  
**Portfolio Page:** `https://devinai.uk/worksai/products/worksai-linkengine/`

## Value Proposition & Scope
Replaces Bitly ($120-$2,388/year) and Pretty Links ($99.60-$499/year) while keeping high-volume click logs out of WordPress's `wp_postmeta` table and automatically flagging dead affiliate destinations.

### What Works Out-of-the-Box (Zero External Credentials Required)
Shortlink creation, UTM builder, device-conditional routing, bot click filtering, and fallback failover.

### What Requires User Configuration (`.env.example`)
A PHP 8.2+ host or Docker container for live PHP execution; optional MaxMind `GEOLITE2_LICENSE_KEY` for city/country IP lookup.

## Measurable Acceptance Criteria
- AC-01: Generates collision-free short codes, enforces `https://`/`http://` destination allowlists (blocking `javascript:`/`data:`/private IPs), and appends normalized UTM parameters.
- AC-02: Resolves device-specific redirect targets (`ios`, `android`, `desktop`) and switches to a configured `fallbackUrl` when a destination is marked unhealthy (`HTTP 404/5xx`).
- AC-03: Separates human clicks from known bot user-agents (`Googlebot`, `AhrefsBot`, `HeadlessChrome`) in analytics summaries.
- AC-04: Ships both the standalone PHP 8.2+ class (`src/LinkEngine.php`), WordPress plugin bridge (`worksai-linkengine-wp.php`), and Composer manifest (`composer.json`).

## Known Limitations
- Local sandbox VM does not include the `php` CLI binary (`php: command not found`); PHP files are validated structurally and paired with an isomorphic Node.js/TypeScript engine for local unit testing, while live PHP runtime deployment awaits a compatible PHP host.
- MaxMind GeoLite2 geolocation requires the user's own free MaxMind license key per the GeoLite2 EULA.

## Quick Start & Verification
```bash
npm test
```
