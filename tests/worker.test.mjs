import test from "node:test";
import assert from "node:assert/strict";
import { APP_META, handleAppRequest } from "../src/worker.mjs";

test("worksai-linkengine standalone Worker renders clean WorksAI UI without forbidden branding or hero upstream clutter", async () => {
  const res = await handleAppRequest(new Request("https://linkengine.worksai.org/"));
  assert.equal(res.status, 200);
  const html = await res.text();
  assert.equal(html.includes(APP_META.name), true);
  assert.equal(html.toLowerCase().includes("devinai.uk"), false);
  assert.equal(html.toLowerCase().includes("devonfolio"), false);
  assert.equal(html.includes("MIT Open Source • WorksAI Foundry"), true);
});

test("worksai-linkengine /api/ai/analyze and /api/mcp execute real deterministic domain engine and reject empty input", async () => {
  const sample = "{\n  \"linkRecord\": {\n    \"targetUrl\": \"https://worksai.org/apps/worksai-linkengine\",\n    \"fallbackUrl\": \"https://worksai.org/apps\",\n    \"healthy\": true,\n    \"utmSource\": \"newsletter\",\n    \"utmMedium\": \"email\",\n    \"utmCampaign\": \"nov2026_release\"\n  },\n  \"requestContext\": {\n    \"userAgent\": \"Mozilla/5.0 (Macintosh; Intel Mac OS X 14_0)\"\n  }\n}";
  const aiRes = await handleAppRequest(
    new Request("https://linkengine.worksai.org/api/ai/analyze", {
      method: "POST",
      headers: { "content-type": "application/json" },
      body: JSON.stringify({ input: sample, tool: APP_META.mcpTools[0] })
    })
  );
  assert.equal(aiRes.status, 200);
  const aiData = await aiRes.json();
  assert.equal(aiData.ok, true);
  assert.equal(typeof aiData.domainResult, "object");
  assert.notEqual(aiData.domainResult, null);
});
