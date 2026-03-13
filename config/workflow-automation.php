<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Table Names
    |--------------------------------------------------------------------------
    |
    | Customize the database table names used by the workflow engine.
    |
    */

    'tables' => [
        'workflows' => 'workflows',
        'nodes' => 'workflow_nodes',
        'edges' => 'workflow_edges',
        'runs' => 'workflow_runs',
        'node_runs' => 'workflow_node_runs',
        'credentials' => 'workflow_credentials',
        'tags' => 'workflow_tags',
        'tag_pivot' => 'workflow_tag_pivot',
        'folders' => 'workflow_folders',
    ],

    /*
    |--------------------------------------------------------------------------
    | Model Classes
    |--------------------------------------------------------------------------
    |
    | Override these to extend the default models with your own.
    |
    */

    'models' => [
        'workflow' => Aftandilmmd\WorkflowAutomation\Models\Workflow::class,
        'node' => Aftandilmmd\WorkflowAutomation\Models\WorkflowNode::class,
        'edge' => Aftandilmmd\WorkflowAutomation\Models\WorkflowEdge::class,
        'run' => Aftandilmmd\WorkflowAutomation\Models\WorkflowRun::class,
        'node_run' => Aftandilmmd\WorkflowAutomation\Models\WorkflowNodeRun::class,
        'credential' => Aftandilmmd\WorkflowAutomation\Models\WorkflowCredential::class,
        'tag' => Aftandilmmd\WorkflowAutomation\Models\WorkflowTag::class,
        'folder' => Aftandilmmd\WorkflowAutomation\Models\WorkflowFolder::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Configuration
    |--------------------------------------------------------------------------
    |
    | When async is true, workflows are dispatched to the queue.
    | Set false for synchronous execution (useful for testing/debugging).
    |
    */

    'async' => env('WORKFLOW_ASYNC', true),
    'queue' => env('WORKFLOW_QUEUE', 'default'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Routes
    |--------------------------------------------------------------------------
    |
    | 'routes'          — Master switch. Set to false to disable ALL routes.
    | 'api_routes'      — Enable/disable the CRUD + execution API endpoints.
    | 'webhook_routes'  — Enable/disable the webhook trigger endpoints.
    |
    | Both 'api_routes' and 'webhook_routes' require 'routes' to be true.
    | When 'routes' is false, everything is disabled regardless.
    |
    */

    'routes' => true,
    'api_routes' => env('WORKFLOW_API_ROUTES', true),
    'editor_routes' => env('WORKFLOW_EDITOR_ROUTES', true),
    'webhook_routes' => env('WORKFLOW_WEBHOOK_ROUTES', true),
    'prefix' => env('WORKFLOW_PREFIX', 'workflow-engine'),
    'middleware' => ['api'],

    /*
    |--------------------------------------------------------------------------
    | Webhook
    |--------------------------------------------------------------------------
    |
    | The URL prefix for webhook trigger endpoints.
    | Webhooks are registered as: POST /{webhook_prefix}/{uuid}
    |
    */

    'webhook_prefix' => 'workflow-webhook',

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting / Concurrency
    |--------------------------------------------------------------------------
    |
    | Control how many workflow runs can execute simultaneously.
    |
    | 'global_max_concurrent'       — Maximum runs across ALL workflows (0 = unlimited).
    | 'max_concurrent_per_workflow'  — Default per-workflow limit (0 = unlimited).
    |                                  Can be overridden per workflow via settings.max_concurrent_runs.
    | 'strategy'                    — What to do when the limit is reached:
    |                                  'exception' — throw RateLimitExceededException
    |                                  'queue'     — release the job back to the queue (async only)
    | 'queue_retry_delay'           — Seconds to wait before retrying a rate-limited queued job.
    |
    */

    'rate_limiting' => [
        'global_max_concurrent' => env('WORKFLOW_GLOBAL_MAX_CONCURRENT', 0),
        'max_concurrent_per_workflow' => env('WORKFLOW_MAX_CONCURRENT_PER_WORKFLOW', 0),
        'strategy' => env('WORKFLOW_RATE_LIMIT_STRATEGY', 'exception'),
        'queue_retry_delay' => env('WORKFLOW_RATE_LIMIT_RETRY_DELAY', 30),
    ],

    /*
    |--------------------------------------------------------------------------
    | Execution Limits
    |--------------------------------------------------------------------------
    */

    'max_execution_time' => env('WORKFLOW_MAX_EXECUTION', 300),
    'default_retry_count' => 0,
    'default_retry_delay_ms' => 1000,
    'retry_backoff' => 'exponential', // linear | exponential

    /*
    |--------------------------------------------------------------------------
    | Expression Engine
    |--------------------------------------------------------------------------
    |
    | 'safe'   — Dot-notation access + whitelisted functions (recommended)
    | 'strict' — Dot-notation access only, no function calls
    |
    */

    'expression_mode' => 'safe',

    /*
    |--------------------------------------------------------------------------
    | Node Auto-Discovery
    |--------------------------------------------------------------------------
    |
    | Directories to scan for classes with the #[AsWorkflowNode] attribute.
    | Package built-in nodes are always registered automatically.
    |
    */

    'node_discovery' => [
        'app_paths' => [
            // app_path('Workflow/Nodes'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins
    |--------------------------------------------------------------------------
    |
    | Register workflow plugins via config. Each entry should be a fully
    | qualified class name implementing PluginInterface. Plugins registered
    | here are loaded during boot, in addition to any plugins registered
    | via WorkflowAutomation::plugin() in service providers.
    |
    */

    'plugins' => [
        // \Acme\WorkflowSlack\SlackPlugin::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Run Command Node
    |--------------------------------------------------------------------------
    |
    | Security settings for the run_command action node.
    |
    | 'allowed_commands' — Whitelist of allowed commands. Supports exact matches
    | and wildcard patterns (e.g. 'cache:*'). When empty, all commands are
    | allowed. It is strongly recommended to set this in production.
    |
    | 'shell_enabled' — Set to false to disable shell commands entirely,
    | allowing only artisan commands. Defaults to true.
    |
    */

    'run_command' => [
        'allowed_commands' => [
            // 'cache:clear',
            // 'cache:forget',
            // 'queue:restart',
            // 'migrate',
            // 'db:seed',
            // './scripts/*',
        ],
        'shell_enabled' => env('WORKFLOW_SHELL_ENABLED', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | AI Node
    |--------------------------------------------------------------------------
    |
    | Default settings for the AI action node. Requires the laravel/ai package.
    |
    | 'default_provider' — Default provider when not set per-node.
    | 'default_model'    — Default model when not set per-node.
    | 'max_tokens'       — Default max tokens limit.
    |
    */

    'ai' => [
        'default_provider' => env('WORKFLOW_AI_PROVIDER'),
        'default_model' => env('WORKFLOW_AI_MODEL'),
        'max_tokens' => env('WORKFLOW_AI_MAX_TOKENS', 4096),
    ],

    /*
    |--------------------------------------------------------------------------
    | AI Builder
    |--------------------------------------------------------------------------
    |
    | Settings for the AI-powered workflow builder chat. Uses laravel/ai to
    | generate nodes and edges from natural-language prompts.
    |
    | 'enabled'          — Enable / disable the AI builder endpoint.
    | 'default_provider' — Default provider when not selected by the user.
    | 'default_model'    — Default model when not selected by the user.
    | 'max_steps'        — Maximum agentic tool-call loops per request.
    |
    */

    'ai_builder' => [
        'enabled' => env('WORKFLOW_AI_BUILDER_ENABLED', true),
        'default_provider' => env('WORKFLOW_AI_BUILDER_PROVIDER', 'openai'),
        'default_model' => env('WORKFLOW_AI_BUILDER_MODEL', 'gpt-4o'),
        'max_steps' => 25,
    ],

    /*
    |--------------------------------------------------------------------------
    | Workflow Chaining
    |--------------------------------------------------------------------------
    |
    | Controls for workflow-to-workflow chaining via the Workflow Trigger node.
    |
    | 'max_depth' — Maximum chain depth to prevent infinite loops.
    |               When workflow A triggers B triggers C... this limits how
    |               deep the chain can go. Set 0 to disable chaining.
    |
    */

    'chaining' => [
        'max_depth' => env('WORKFLOW_CHAIN_MAX_DEPTH', 10),
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Retention
    |--------------------------------------------------------------------------
    |
    | Workflow run records older than this many days will be pruned
    | by the workflow:clean-runs command. Set 0 to disable pruning.
    |
    */

    'log_retention_days' => env('WORKFLOW_LOG_RETENTION', 30),

    /*
    |--------------------------------------------------------------------------
    | MCP Server (Model Context Protocol)
    |--------------------------------------------------------------------------
    |
    | Enable the built-in MCP server so AI clients (Claude, GPT, etc.) can
    | create, edit, and execute workflows through the MCP protocol.
    |
    | Requires the laravel/mcp package: composer require laravel/mcp
    |
    */

    'mcp' => [
        'enabled' => env('WORKFLOW_MCP_ENABLED', false),
        'path' => '/mcp/workflow',
    ],

];
