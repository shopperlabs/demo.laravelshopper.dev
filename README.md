<p align="center">
    <a href="https://demo.laravelshopper.dev" title="Shopper demo store">
        <img src="art/demo-store.jpg" alt="Shopper Demo Store">
    </a>
</p>

# Laravel Workflow Automation Demo

A real-world e-commerce application showcasing [Laravel Workflow Automation](https://github.com/aftandilmmd/laravel-workflow-automation) in action. Built on top of the [Shopper](https://laravelshopper.dev) demo store, this project demonstrates how to automate complex business processes — order pipelines, inventory management, customer engagement, AI-powered moderation, and more — using a visual, node-based workflow engine.

## Getting started

Clone and install:

```sh
git clone https://github.com/aftandilmmd/laravel-workflow-automation-demo.git && cd laravel-workflow-automation-demo
composer install
npm install && npm run build
```

Set up the project:

```sh
composer setup
```

Then access the storefront at the URL provided by your local server and log in to the admin panel at `/cpanel`:

- **Email:** admin@laravelshopper.dev
- **Password:** demo.Shopper@2026!

## Included Workflows

The demo ships with **12 production-ready workflows** that solve real e-commerce problems:

### Order Management

| Workflow | Trigger | What it does |
|----------|---------|-------------|
| **New Order Processing Pipeline** | Order created | Validates payment, routes by order value, sends priority alerts for high-value orders, auto-confirms standard orders |
| **Order Fulfillment Pipeline** | Order status → processing | Loops through line items, checks stock per item, reserves inventory or triggers backorder alerts, sends fulfillment summary |
| **Refund Processing with Approval** | Manual | Small refunds auto-approve; large refunds pause for manager approval via wait/resume gate, with 48h timeout escalation |

### Inventory & Catalog

| Workflow | Trigger | What it does |
|----------|---------|-------------|
| **Low Stock Alert & Reorder Suggestions** | Daily at 08:00 | Queries products below threshold, filters critical stock (< 3 units), aggregates by brand, emails purchasing team |
| **Product Price Change Alerts** | Product price updated | Detects price direction (increase/decrease) via switch node, notifies marketing or operations accordingly |
| **Product Catalog Multi-Channel Publish** | Product created | Syncs to external marketplace via HTTP, runs AI-powered SEO analysis in parallel, merges results, notifies marketing |
| **Webhook Inventory Sync** | Webhook (POST) | Receives stock updates from external warehouse systems, loops through products, updates levels, reports sync summary |

### Customer Engagement

| Workflow | Trigger | What it does |
|----------|---------|-------------|
| **Customer Welcome Drip Sequence** | New user registered | 3-step email drip: welcome (1 min) → product recommendations (24h) → first-purchase discount code (3 days) |
| **AI-Powered Review Moderation** | Review submitted | AI sentiment analysis classifies reviews; positive → auto-approve, inappropriate → flag + notify moderation team |
| **Abandoned Cart Recovery** | Manual | Sends reminder after 1 hour, checks if purchased after 24 hours, sends discount offer if not |
| **Weekly Customer Segmentation** | Monday at 06:00 | Analyzes spending patterns, identifies VIP customers (> 100k spend + 3 orders), sends VIP status emails and management report |

### Reporting

| Workflow | Trigger | What it does |
|----------|---------|-------------|
| **Daily Revenue & Sales Report** | Daily at 23:00 | Gathers today's orders, calculates total revenue, order count, average value, and items sold, emails management |

## Node Types Demonstrated

The workflows collectively showcase **20 of 28** available node types:

| Category | Nodes Used |
|----------|-----------|
| **Triggers** | `model_event`, `schedule`, `manual`, `webhook` |
| **Actions** | `send_mail`, `update_model`, `http_request`, `run_command`, `ai` |
| **Conditions** | `if_condition`, `switch` |
| **Transformers** | `set_fields`, `parse_data` |
| **Controls** | `delay`, `loop`, `merge`, `wait_resume`, `error_handler` |
| **Utilities** | `filter`, `aggregate`, `code` |
| **Annotations** | `sticky_note` |

## Key Patterns Worth Studying

| Pattern | Workflow | What to look for |
|---------|----------|-----------------|
| Conditional branching | New Order Processing | Nested `if_condition` nodes routing by payment status and order value |
| Timed drip sequences | Customer Welcome | Chained `delay` nodes creating a multi-day email sequence |
| AI integration | Review Moderation | `ai` node with structured JSON output parsed by `parse_data` |
| Approval gates | Refund Processing | `wait_resume` node pausing execution until external approval with timeout |
| Parallel execution | Product Catalog Publish | Two branches (marketplace sync + SEO analysis) merging via `merge` node |
| Loop processing | Order Fulfillment | `loop` node iterating order items with per-item stock checks |
| Webhook ingestion | Inventory Sync | `webhook` trigger receiving external POST data with error handling |
| Scheduled reports | Daily Revenue | `schedule` trigger + `run_command` + `aggregate` for data collection |
| Multi-branch routing | Price Change Alerts | `switch` node routing to different handlers based on price direction |
| Error resilience | Product Catalog Publish | `error_handler` with regex-based routing (retry, notify, ignore) |

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Framework | Laravel 12 |
| Workflow Engine | [Laravel Workflow Automation](https://github.com/aftandilmmd/laravel-workflow-automation) |
| Admin Panel | Shopper + Filament 4 |
| Reactivity | Livewire 3 + Volt |
| UI Components | Flux UI |
| Styling | Tailwind CSS 4 |

## E-Commerce Storefront

This demo also includes a full storefront with product catalog, multi-step checkout, customer accounts, a blog, and zone-based pricing — providing the rich domain context that makes the workflow automations realistic.
