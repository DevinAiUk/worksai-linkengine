export const APP_DB_CONFIG = {
  schema: "worksai_hub",
  appSlug: "worksai-linkengine",
  subdomain: "linkengine.worksai.org",
  mcpEndpoint: "https://linkengine.worksai.org/api/mcp",
  aiEndpoint: "https://linkengine.worksai.org/api/ai/analyze",
  mcpTools: ["linkengine.create_shortlink", "linkengine.validate_utm", "linkengine.check_link_rot"]
} as const;
