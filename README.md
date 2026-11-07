# WorksAi LinkEngine (`worksai-linkengine`)

> MIT-licensed PHP URL shortener, UTM campaign builder, and WordPress bridge with link-rot detection.

- **Live Subdomain Application:** [https://linkengine.worksai.org](https://linkengine.worksai.org)
- **WorksAI Hub Specification:** [https://worksai.org/apps/worksai-linkengine](https://worksai.org/apps/worksai-linkengine)
- **Category:** D. WordPress/PHP products
- **License:** MIT (Derived from [Shlink](https://github.com/shlinkio/shlink) @ `9008811`)

## Capability Matrix
- **What You Can Do:** Install the working PHP 8.2+ / WordPress plugin bridge (worksai-linkengine-wp-bridge.php) or call the Edge API to resolve smart shortlinks with SSRF protection, bot filtering, device routing, and UTM injection.
- **Deterministic Domain Utilities:** resolveSmartShortlink (SSRF private-IP blocker, bot user-agent filter, iOS/Android/fallback router, and UTM query builder).
- **Genuine AI Model Features:** Cloudflare Workers AI (@cf/meta/llama-3.1-8b-instruct) semantic anchor-text and internal topic-cluster link recommendations.
- **Persisted R2/Neon Features:** Shortlink resolution logs and UTM campaign rules persisted in Cloudflare R2 (workspaces/worksai-linkengine/*).
- **Known Limitations:** Automatic WordPress post-save hook execution requires installing the downloadable PHP plugin on a WordPress host.

## Verification & Local Testing
```bash
npm run lint
npm run typecheck
npm test
```
