<?php

declare(strict_types=1);

namespace Database\Seeders;

use Aftandilmmd\WorkflowAutomation\Models\Workflow;
use Aftandilmmd\WorkflowAutomation\Models\WorkflowFolder;
use Aftandilmmd\WorkflowAutomation\Models\WorkflowTag;
use Illuminate\Database\Seeder;

class WorkflowSeeder extends Seeder
{
    /** @var array<string, WorkflowTag> */
    private array $tags = [];

    /** @var array<string, WorkflowFolder> */
    private array $folders = [];

    public function run(): void
    {
        $this->command->warn(PHP_EOL.'Creating workflow tags...');
        $this->createTags();

        $this->command->warn('Creating workflow folders...');
        $this->createFolders();

        $this->command->warn('Creating workflows...');

        $this->createNewOrderProcessingWorkflow();
        $this->createLowStockAlertWorkflow();
        $this->createCustomerWelcomeSequenceWorkflow();
        $this->createProductReviewModerationWorkflow();
        $this->createAbandonedCartRecoveryWorkflow();
        $this->createDailyRevenueReportWorkflow();
        $this->createProductPriceChangeNotificationWorkflow();
        $this->createOrderFulfillmentPipelineWorkflow();
        $this->createCustomerSegmentationWorkflow();
        $this->createWebhookInventorySyncWorkflow();
        $this->createRefundProcessingWorkflow();
        $this->createNewProductCatalogPublishWorkflow();

        $this->command->info('12 workflows created successfully.');
    }

    private function createTags(): void
    {
        $tagData = [
            ['name' => 'E-Commerce', 'color' => '#3B82F6'],
            ['name' => 'Orders', 'color' => '#F59E0B'],
            ['name' => 'Inventory', 'color' => '#10B981'],
            ['name' => 'Customers', 'color' => '#8B5CF6'],
            ['name' => 'Notifications', 'color' => '#EF4444'],
            ['name' => 'Reports', 'color' => '#6366F1'],
            ['name' => 'Marketing', 'color' => '#EC4899'],
            ['name' => 'Moderation', 'color' => '#F97316'],
            ['name' => 'Fulfillment', 'color' => '#14B8A6'],
            ['name' => 'Integrations', 'color' => '#64748B'],
        ];

        foreach ($tagData as $tag) {
            $this->tags[$tag['name']] = WorkflowTag::query()->create($tag);
        }
    }

    private function createFolders(): void
    {
        $this->folders['Order Management'] = WorkflowFolder::query()->create(['name' => 'Order Management']);
        $this->folders['Inventory'] = WorkflowFolder::query()->create(['name' => 'Inventory & Catalog']);
        $this->folders['Customer Engagement'] = WorkflowFolder::query()->create(['name' => 'Customer Engagement']);
        $this->folders['Reports'] = WorkflowFolder::query()->create(['name' => 'Reports & Analytics']);
        $this->folders['Integrations'] = WorkflowFolder::query()->create(['name' => 'Integrations']);
    }

    /**
     * 1. New Order Processing Pipeline
     *
     * Trigger: Order created → Check payment status → Route by order value →
     * High-value: send priority email + flag for manual review
     * Standard: auto-confirm + send confirmation email
     */
    private function createNewOrderProcessingWorkflow(): void
    {
        $workflow = Workflow::query()->create([
            'name' => 'New Order Processing Pipeline',
            'description' => 'Processes new orders by validating payment, routing by order value, sending confirmations, and flagging high-value orders for manual review.',
            'is_active' => true,
            'run_async' => true,
            'settings' => [],
            'created_via' => 'code',
            'folder_id' => $this->folders['Order Management']->id,
        ]);

        $workflow->attachTags([
            $this->tags['E-Commerce']->id,
            $this->tags['Orders']->id,
            $this->tags['Notifications']->id,
        ]);

        // Nodes
        $trigger = $workflow->addNode('Order Created', 'model_event', [
            'model' => 'Shopper\\Core\\Models\\Order',
            'events' => ['created'],
        ]);

        $setFields = $workflow->addNode('Enrich Order Data', 'set_fields', [
            'fields' => [
                'order_id' => '{{ model.id }}',
                'customer_email' => '{{ model.customer.email }}',
                'customer_name' => '{{ model.customer.first_name }} {{ model.customer.last_name }}',
                'order_total' => '{{ model.total_amount }}',
                'currency' => '{{ model.currency_code }}',
            ],
            'keep_existing' => true,
        ]);

        $checkPayment = $workflow->addNode('Check Payment Status', 'if_condition', [
            'field' => '{{ model.payment_status }}',
            'operator' => 'equals',
            'value' => 'paid',
        ]);

        $routeByValue = $workflow->addNode('Route by Order Value', 'if_condition', [
            'field' => '{{ model.total_amount }}',
            'operator' => 'greater_than',
            'value' => '50000',
        ]);

        $highValueEmail = $workflow->addNode('Send Priority Notification', 'send_mail', [
            'send_mode' => 'inline',
            'to' => 'operations@shopstation.test',
            'subject' => '🔔 High-Value Order #{{ order_id }} - {{ currency }} {{ order_total }}',
            'body' => '<h2>High-Value Order Received</h2><p>Order #{{ order_id }} from {{ customer_name }} ({{ customer_email }}) totaling {{ currency }} {{ order_total }} requires priority handling.</p>',
            'is_html' => true,
        ]);

        $flagOrder = $workflow->addNode('Flag for Manual Review', 'update_model', [
            'model' => 'Shopper\\Core\\Models\\Order',
            'find_by' => 'id',
            'find_value' => '{{ model.id }}',
            'fields' => [
                'notes' => 'HIGH VALUE - Manual review required',
            ],
        ]);

        $confirmEmail = $workflow->addNode('Send Order Confirmation', 'send_mail', [
            'send_mode' => 'inline',
            'to' => '{{ customer_email }}',
            'subject' => 'Order Confirmed #{{ order_id }}',
            'body' => '<h2>Thank you, {{ customer_name }}!</h2><p>Your order #{{ order_id }} has been confirmed. We will notify you once it ships.</p>',
            'is_html' => true,
        ]);

        $paymentPendingEmail = $workflow->addNode('Payment Pending Notice', 'send_mail', [
            'send_mode' => 'inline',
            'to' => '{{ customer_email }}',
            'subject' => 'Payment Pending - Order #{{ order_id }}',
            'body' => '<p>Hi {{ customer_name }},</p><p>Your order #{{ order_id }} is awaiting payment confirmation. Please complete your payment to proceed.</p>',
            'is_html' => true,
        ]);

        $workflow->addNode('Process Note', 'sticky_note', [
            'content' => 'Orders above 50,000 (in base currency cents) are considered high-value and require manual review by the operations team.',
            'color' => 'yellow',
        ]);

        // Edges
        $workflow->connect($trigger, $setFields);
        $workflow->connect($setFields, $checkPayment);
        $workflow->connect($checkPayment, $routeByValue, 'true', 'main');
        $workflow->connect($checkPayment, $paymentPendingEmail, 'false', 'main');
        $workflow->connect($routeByValue, $highValueEmail, 'true', 'main');
        $workflow->connect($routeByValue, $confirmEmail, 'false', 'main');
        $workflow->connect($highValueEmail, $flagOrder);

        $this->command->info('  ✓ New Order Processing Pipeline');
    }

    /**
     * 2. Low Stock Alert & Auto-Reorder
     *
     * Schedule: Runs daily → Query products → Filter low stock → Aggregate by brand →
     * Send summary email to purchasing team
     */
    private function createLowStockAlertWorkflow(): void
    {
        $workflow = Workflow::query()->create([
            'name' => 'Low Stock Alert & Reorder Suggestions',
            'description' => 'Runs daily to check inventory levels, identifies products below threshold, aggregates by brand, and sends a purchasing summary to the team.',
            'is_active' => true,
            'run_async' => true,
            'settings' => [],
            'created_via' => 'code',
            'folder_id' => $this->folders['Inventory']->id,
        ]);

        $workflow->attachTags([
            $this->tags['Inventory']->id,
            $this->tags['Reports']->id,
        ]);

        $trigger = $workflow->addNode('Daily Stock Check', 'schedule', [
            'interval_type' => 'custom_cron',
            'cron' => '0 8 * * *',
        ]);

        $fetchProducts = $workflow->addNode('Run Stock Query', 'run_command', [
            'command_type' => 'artisan',
            'command' => 'tinker',
            'arguments' => [
                '--execute' => 'echo json_encode(\\App\\Models\\Product::withCurrentStock()->get()->filter(fn($p) => $p->stock < 10)->map(fn($p) => ["id" => $p->id, "name" => $p->name, "sku" => $p->sku, "stock" => $p->stock, "brand" => $p->brand?->name])->values()->toArray());',
            ],
            'include_output' => true,
        ]);

        $parseResults = $workflow->addNode('Parse Stock Data', 'parse_data', [
            'source_field' => 'command_result.output',
            'format' => 'json',
            'target_field' => 'low_stock_products',
        ]);

        $filterCritical = $workflow->addNode('Filter Critical (< 3 units)', 'filter', [
            'conditions' => [
                ['field' => 'stock', 'operator' => 'less_than', 'value' => '3'],
            ],
            'logic' => 'and',
        ]);

        $aggregateByBrand = $workflow->addNode('Aggregate by Brand', 'aggregate', [
            'group_by' => 'brand',
            'operations' => [
                ['field' => 'stock', 'function' => 'count', 'alias' => 'products_count'],
                ['field' => 'stock', 'function' => 'sum', 'alias' => 'total_remaining_stock'],
            ],
        ]);

        $sendAlert = $workflow->addNode('Send Stock Alert Email', 'send_mail', [
            'send_mode' => 'inline',
            'to' => 'purchasing@shopstation.test',
            'subject' => '⚠️ Daily Low Stock Alert - {{ _items_count }} products need attention',
            'body' => '<h2>Low Stock Summary</h2><p>The following products have critically low inventory (< 3 units) and may need reordering.</p><p>Review the purchasing dashboard for detailed actions.</p>',
            'is_html' => true,
        ]);

        $workflow->connect($trigger, $fetchProducts);
        $workflow->connect($fetchProducts, $parseResults);
        $workflow->connect($parseResults, $filterCritical);
        $workflow->connect($filterCritical, $aggregateByBrand);
        $workflow->connect($aggregateByBrand, $sendAlert);

        $this->command->info('  ✓ Low Stock Alert & Reorder Suggestions');
    }

    /**
     * 3. Customer Welcome Sequence
     *
     * Trigger: New customer created → Delay 1 min → Send welcome email →
     * Delay 24 hours → Send product recommendations → Delay 3 days → Send discount code
     */
    private function createCustomerWelcomeSequenceWorkflow(): void
    {
        $workflow = Workflow::query()->create([
            'name' => 'Customer Welcome Drip Sequence',
            'description' => 'Automated 3-step email drip campaign for new customers: welcome email, product recommendations after 24h, and a discount code after 3 days.',
            'is_active' => true,
            'run_async' => true,
            'settings' => [],
            'created_via' => 'code',
            'folder_id' => $this->folders['Customer Engagement']->id,
        ]);

        $workflow->attachTags([
            $this->tags['Customers']->id,
            $this->tags['Marketing']->id,
            $this->tags['Notifications']->id,
        ]);

        $trigger = $workflow->addNode('New Customer Registered', 'model_event', [
            'model' => 'App\\Models\\User',
            'events' => ['created'],
        ]);

        $setCustomerData = $workflow->addNode('Extract Customer Info', 'set_fields', [
            'fields' => [
                'email' => '{{ model.email }}',
                'first_name' => '{{ model.first_name }}',
                'customer_id' => '{{ model.id }}',
            ],
            'keep_existing' => true,
        ]);

        $shortDelay = $workflow->addNode('Wait 1 Minute', 'delay', [
            'delay_type' => 'minutes',
            'delay_value' => 1,
        ]);

        $welcomeEmail = $workflow->addNode('Send Welcome Email', 'send_mail', [
            'send_mode' => 'inline',
            'to' => '{{ email }}',
            'subject' => 'Welcome to ShopStation, {{ first_name }}! 🎉',
            'body' => '<h2>Welcome aboard, {{ first_name }}!</h2><p>We\'re thrilled to have you join ShopStation. Explore our curated collection of products from top brands worldwide.</p><p>Happy shopping!</p>',
            'is_html' => true,
        ]);

        $dayDelay = $workflow->addNode('Wait 24 Hours', 'delay', [
            'delay_type' => 'hours',
            'delay_value' => 24,
        ]);

        $recommendationsEmail = $workflow->addNode('Send Product Recommendations', 'send_mail', [
            'send_mode' => 'inline',
            'to' => '{{ email }}',
            'subject' => 'Handpicked for you, {{ first_name }} ✨',
            'body' => '<h2>Products You\'ll Love</h2><p>Based on what\'s trending at ShopStation, we think you\'ll enjoy these popular items. Check out our latest arrivals and bestsellers!</p>',
            'is_html' => true,
        ]);

        $threeDayDelay = $workflow->addNode('Wait 3 Days', 'delay', [
            'delay_type' => 'hours',
            'delay_value' => 72,
        ]);

        $discountEmail = $workflow->addNode('Send First Purchase Discount', 'send_mail', [
            'send_mode' => 'inline',
            'to' => '{{ email }}',
            'subject' => '🎁 Your exclusive 15% off, {{ first_name }}!',
            'body' => '<h2>A Special Gift Just for You</h2><p>As a new member, enjoy 15% off your first order with code <strong>WELCOME15</strong>.</p><p>This offer expires in 7 days — don\'t miss out!</p>',
            'is_html' => true,
        ]);

        $workflow->connect($trigger, $setCustomerData);
        $workflow->connect($setCustomerData, $shortDelay);
        $workflow->connect($shortDelay, $welcomeEmail);
        $workflow->connect($welcomeEmail, $dayDelay);
        $workflow->connect($dayDelay, $recommendationsEmail);
        $workflow->connect($recommendationsEmail, $threeDayDelay);
        $workflow->connect($threeDayDelay, $discountEmail);

        $this->command->info('  ✓ Customer Welcome Drip Sequence');
    }

    /**
     * 4. Product Review Moderation with AI
     *
     * Trigger: Review created → AI sentiment analysis → Route by sentiment →
     * Positive: auto-approve → Negative: flag for manual review + notify team
     */
    private function createProductReviewModerationWorkflow(): void
    {
        $workflow = Workflow::query()->create([
            'name' => 'AI-Powered Review Moderation',
            'description' => 'Automatically moderates product reviews using AI sentiment analysis. Positive reviews are auto-approved; negative or suspicious reviews are flagged for manual review.',
            'is_active' => true,
            'run_async' => true,
            'settings' => [],
            'created_via' => 'code',
            'folder_id' => $this->folders['Customer Engagement']->id,
        ]);

        $workflow->attachTags([
            $this->tags['Moderation']->id,
            $this->tags['Customers']->id,
        ]);

        $trigger = $workflow->addNode('Review Submitted', 'model_event', [
            'model' => 'Shopper\\Core\\Models\\Review',
            'events' => ['created'],
        ]);

        $enrichData = $workflow->addNode('Prepare Review Data', 'set_fields', [
            'fields' => [
                'review_id' => '{{ model.id }}',
                'review_title' => '{{ model.title }}',
                'review_content' => '{{ model.content }}',
                'rating' => '{{ model.rating }}',
                'reviewer_name' => '{{ model.author.first_name }}',
            ],
            'keep_existing' => true,
        ]);

        $aiAnalysis = $workflow->addNode('AI Sentiment Analysis', 'ai', [
            'prompt' => 'Analyze this product review for sentiment and appropriateness. Review title: "{{ review_title }}" Content: "{{ review_content }}" Rating: {{ rating }}/5. Respond with ONLY a JSON object: {"sentiment": "positive|negative|neutral", "is_appropriate": true|false, "confidence": 0.0-1.0, "reason": "brief explanation"}',
            'system_prompt' => 'You are a content moderation assistant for an e-commerce platform. Analyze reviews for sentiment, spam, offensive content, and relevance. Be strict about inappropriate content but fair to genuine negative reviews.',
            'provider' => 'anthropic',
            'model' => 'claude-haiku-4-5-20251001',
            'temperature' => '0.1',
            'max_tokens' => 200,
            'output_key' => 'analysis',
        ]);

        $parseAiResult = $workflow->addNode('Parse AI Response', 'parse_data', [
            'source_field' => 'analysis',
            'format' => 'json',
            'target_field' => 'sentiment_data',
        ]);

        $checkAppropriate = $workflow->addNode('Is Review Appropriate?', 'if_condition', [
            'field' => '{{ sentiment_data.is_appropriate }}',
            'operator' => 'equals',
            'value' => 'true',
        ]);

        $autoApprove = $workflow->addNode('Auto-Approve Review', 'update_model', [
            'model' => 'Shopper\\Core\\Models\\Review',
            'find_by' => 'id',
            'find_value' => '{{ review_id }}',
            'fields' => [
                'is_recommended' => true,
            ],
        ]);

        $flagReview = $workflow->addNode('Flag for Manual Review', 'update_model', [
            'model' => 'Shopper\\Core\\Models\\Review',
            'find_by' => 'id',
            'find_value' => '{{ review_id }}',
            'fields' => [
                'is_recommended' => false,
            ],
        ]);

        $notifyTeam = $workflow->addNode('Notify Moderation Team', 'send_mail', [
            'send_mode' => 'inline',
            'to' => 'moderation@shopstation.test',
            'subject' => '🚩 Review Flagged - #{{ review_id }} requires attention',
            'body' => '<h3>Flagged Review</h3><p><strong>Title:</strong> {{ review_title }}</p><p><strong>Content:</strong> {{ review_content }}</p><p><strong>Rating:</strong> {{ rating }}/5</p><p><strong>AI Reason:</strong> {{ sentiment_data.reason }}</p>',
            'is_html' => true,
        ]);

        $errorHandler = $workflow->addNode('Handle AI Errors', 'error_handler', [
            'rules' => [
                ['match' => '.*timeout.*', 'route' => 'retry'],
                ['match' => '.*rate.limit.*', 'route' => 'retry'],
                ['match' => '.*', 'route' => 'notify'],
            ],
            'default_route' => 'notify',
        ]);

        $workflow->connect($trigger, $enrichData);
        $workflow->connect($enrichData, $aiAnalysis);
        $workflow->connect($aiAnalysis, $parseAiResult, 'main', 'main');
        $workflow->connect($aiAnalysis, $errorHandler, 'error', 'main');
        $workflow->connect($parseAiResult, $checkAppropriate);
        $workflow->connect($checkAppropriate, $autoApprove, 'true', 'main');
        $workflow->connect($checkAppropriate, $flagReview, 'false', 'main');
        $workflow->connect($flagReview, $notifyTeam);

        $this->command->info('  ✓ AI-Powered Review Moderation');
    }

    /**
     * 5. Abandoned Cart Recovery
     *
     * Manual trigger with cart data → Wait 1 hour → Send reminder →
     * Wait 24 hours → Check if purchased → If not: send discount offer
     */
    private function createAbandonedCartRecoveryWorkflow(): void
    {
        $workflow = Workflow::query()->create([
            'name' => 'Abandoned Cart Recovery',
            'description' => 'Multi-step abandoned cart recovery: sends a reminder after 1 hour, then a discount offer after 24 hours if the customer hasn\'t completed the purchase.',
            'is_active' => true,
            'run_async' => true,
            'settings' => [],
            'created_via' => 'code',
            'folder_id' => $this->folders['Customer Engagement']->id,
        ]);

        $workflow->attachTags([
            $this->tags['Marketing']->id,
            $this->tags['E-Commerce']->id,
        ]);

        $trigger = $workflow->addNode('Cart Abandoned', 'manual', [
            'input_schema' => [
                'customer_email' => 'string',
                'customer_name' => 'string',
                'cart_items' => 'array',
                'cart_total' => 'number',
                'cart_id' => 'string',
            ],
        ]);

        $hourDelay = $workflow->addNode('Wait 1 Hour', 'delay', [
            'delay_type' => 'hours',
            'delay_value' => 1,
        ]);

        $reminderEmail = $workflow->addNode('Send Cart Reminder', 'send_mail', [
            'send_mode' => 'inline',
            'to' => '{{ customer_email }}',
            'subject' => 'You left something behind, {{ customer_name }}! 🛒',
            'body' => '<h2>Your cart is waiting!</h2><p>Hi {{ customer_name }},</p><p>You left items in your cart worth {{ cart_total }}. Complete your purchase before they sell out!</p>',
            'is_html' => true,
        ]);

        $dayDelay = $workflow->addNode('Wait 24 Hours', 'delay', [
            'delay_type' => 'hours',
            'delay_value' => 24,
        ]);

        $checkPurchased = $workflow->addNode('Did Customer Purchase?', 'if_condition', [
            'field' => '{{ purchased }}',
            'operator' => 'equals',
            'value' => 'false',
        ]);

        $discountEmail = $workflow->addNode('Send Discount Offer', 'send_mail', [
            'send_mode' => 'inline',
            'to' => '{{ customer_email }}',
            'subject' => '10% off your cart, {{ customer_name }}! Last chance 🎯',
            'body' => '<h2>Here\'s a little nudge!</h2><p>Hi {{ customer_name }},</p><p>We noticed you haven\'t completed your purchase. Use code <strong>COMEBACK10</strong> for 10% off your cart of {{ cart_total }}.</p><p>Offer expires in 48 hours!</p>',
            'is_html' => true,
        ]);

        $workflow->connect($trigger, $hourDelay);
        $workflow->connect($hourDelay, $reminderEmail);
        $workflow->connect($reminderEmail, $dayDelay);
        $workflow->connect($dayDelay, $checkPurchased);
        $workflow->connect($checkPurchased, $discountEmail, 'true', 'main');

        $this->command->info('  ✓ Abandoned Cart Recovery');
    }

    /**
     * 6. Daily Revenue Report
     *
     * Schedule: Every day at 23:00 → Run Artisan command to gather stats →
     * Parse data → Aggregate totals → Send daily report
     */
    private function createDailyRevenueReportWorkflow(): void
    {
        $workflow = Workflow::query()->create([
            'name' => 'Daily Revenue & Sales Report',
            'description' => 'Generates a daily summary of revenue, order count, and top products. Runs at 23:00 and emails the report to the management team.',
            'is_active' => true,
            'run_async' => true,
            'settings' => [],
            'created_via' => 'code',
            'folder_id' => $this->folders['Reports']->id,
        ]);

        $workflow->attachTags([
            $this->tags['Reports']->id,
            $this->tags['E-Commerce']->id,
        ]);

        $trigger = $workflow->addNode('Daily at 23:00', 'schedule', [
            'interval_type' => 'custom_cron',
            'cron' => '0 23 * * *',
        ]);

        $fetchOrders = $workflow->addNode('Fetch Today\'s Orders', 'run_command', [
            'command_type' => 'artisan',
            'command' => 'tinker',
            'arguments' => [
                '--execute' => 'echo json_encode(\\Shopper\\Core\\Models\\Order::whereDate("created_at", today())->get()->map(fn($o) => ["id" => $o->id, "total" => $o->total_amount, "status" => $o->status->value, "payment_status" => $o->payment_status->value, "items_count" => $o->items->count()])->toArray());',
            ],
            'include_output' => true,
        ]);

        $parseOrders = $workflow->addNode('Parse Order Data', 'parse_data', [
            'source_field' => 'command_result.output',
            'format' => 'json',
            'target_field' => 'orders',
        ]);

        $aggregateRevenue = $workflow->addNode('Calculate Revenue Stats', 'aggregate', [
            'operations' => [
                ['field' => 'total', 'function' => 'sum', 'alias' => 'total_revenue'],
                ['field' => 'total', 'function' => 'count', 'alias' => 'order_count'],
                ['field' => 'total', 'function' => 'avg', 'alias' => 'avg_order_value'],
                ['field' => 'items_count', 'function' => 'sum', 'alias' => 'total_items_sold'],
            ],
        ]);

        $sendReport = $workflow->addNode('Send Revenue Report', 'send_mail', [
            'send_mode' => 'inline',
            'to' => 'management@shopstation.test',
            'subject' => '📊 Daily Revenue Report - {{ _date }}',
            'body' => '<h2>Daily Sales Summary</h2><table><tr><td><strong>Total Revenue:</strong></td><td>{{ total_revenue }}</td></tr><tr><td><strong>Orders:</strong></td><td>{{ order_count }}</td></tr><tr><td><strong>Avg Order Value:</strong></td><td>{{ avg_order_value }}</td></tr><tr><td><strong>Items Sold:</strong></td><td>{{ total_items_sold }}</td></tr></table>',
            'is_html' => true,
        ]);

        $workflow->connect($trigger, $fetchOrders);
        $workflow->connect($fetchOrders, $parseOrders);
        $workflow->connect($parseOrders, $aggregateRevenue);
        $workflow->connect($aggregateRevenue, $sendReport);

        $this->command->info('  ✓ Daily Revenue & Sales Report');
    }

    /**
     * 7. Product Price Change Notification
     *
     * Trigger: Product updated (price fields) → Compare old/new prices →
     * If decreased: notify subscribed customers
     * If increased: notify operations
     */
    private function createProductPriceChangeNotificationWorkflow(): void
    {
        $workflow = Workflow::query()->create([
            'name' => 'Product Price Change Alerts',
            'description' => 'Monitors product price changes and notifies customers of price drops or alerts operations about price increases.',
            'is_active' => true,
            'run_async' => true,
            'settings' => [],
            'created_via' => 'code',
            'folder_id' => $this->folders['Inventory']->id,
        ]);

        $workflow->attachTags([
            $this->tags['E-Commerce']->id,
            $this->tags['Notifications']->id,
        ]);

        $trigger = $workflow->addNode('Product Updated', 'model_event', [
            'model' => 'App\\Models\\Product',
            'events' => ['updated'],
            'only_fields' => ['price_amount'],
        ]);

        $setData = $workflow->addNode('Extract Price Data', 'set_fields', [
            'fields' => [
                'product_id' => '{{ model.id }}',
                'product_name' => '{{ model.name }}',
                'product_sku' => '{{ model.sku }}',
            ],
            'keep_existing' => true,
        ]);

        $checkDirection = $workflow->addNode('Price Increased or Decreased?', 'switch', [
            'field' => '{{ price_direction }}',
            'cases' => [
                ['port' => 'case_decrease', 'operator' => 'equals', 'value' => 'decreased'],
                ['port' => 'case_increase', 'operator' => 'equals', 'value' => 'increased'],
            ],
            'fallthrough' => true,
        ]);

        $priceDropEmail = $workflow->addNode('Notify: Price Drop', 'send_mail', [
            'send_mode' => 'inline',
            'to' => 'marketing@shopstation.test',
            'subject' => '💰 Price Drop: {{ product_name }}',
            'body' => '<h3>Price Decrease Alert</h3><p><strong>{{ product_name }}</strong> (SKU: {{ product_sku }}) price has been reduced.</p><p>Consider sending a promotional email to customers who viewed this product.</p>',
            'is_html' => true,
        ]);

        $priceIncreaseEmail = $workflow->addNode('Notify: Price Increase', 'send_mail', [
            'send_mode' => 'inline',
            'to' => 'operations@shopstation.test',
            'subject' => '📈 Price Increase: {{ product_name }}',
            'body' => '<h3>Price Increase Notice</h3><p><strong>{{ product_name }}</strong> (SKU: {{ product_sku }}) price has been increased.</p><p>Please update any active promotions or advertisements.</p>',
            'is_html' => true,
        ]);

        $workflow->connect($trigger, $setData);
        $workflow->connect($setData, $checkDirection);
        $workflow->connect($checkDirection, $priceDropEmail, 'case_decrease', 'main');
        $workflow->connect($checkDirection, $priceIncreaseEmail, 'case_increase', 'main');

        $this->command->info('  ✓ Product Price Change Alerts');
    }

    /**
     * 8. Order Fulfillment Pipeline
     *
     * Trigger: Order status changed to "processing" → Loop through items →
     * Check stock per item → If in stock: reserve → If not: backorder notification →
     * Merge results → Send fulfillment summary
     */
    private function createOrderFulfillmentPipelineWorkflow(): void
    {
        $workflow = Workflow::query()->create([
            'name' => 'Order Fulfillment Pipeline',
            'description' => 'Processes order fulfillment by iterating through line items, checking stock availability, reserving inventory, and handling backorders with notifications.',
            'is_active' => true,
            'run_async' => true,
            'settings' => [],
            'created_via' => 'code',
            'folder_id' => $this->folders['Order Management']->id,
        ]);

        $workflow->attachTags([
            $this->tags['Fulfillment']->id,
            $this->tags['Orders']->id,
            $this->tags['Inventory']->id,
        ]);

        $trigger = $workflow->addNode('Order Status: Processing', 'model_event', [
            'model' => 'Shopper\\Core\\Models\\Order',
            'events' => ['updated'],
            'only_fields' => ['status'],
        ]);

        $checkStatus = $workflow->addNode('Is Status Processing?', 'if_condition', [
            'field' => '{{ model.status }}',
            'operator' => 'equals',
            'value' => 'processing',
        ]);

        $setOrderData = $workflow->addNode('Prepare Order Data', 'set_fields', [
            'fields' => [
                'order_id' => '{{ model.id }}',
                'order_number' => '{{ model.number }}',
                'items' => '{{ model.items }}',
            ],
            'keep_existing' => true,
        ]);

        $loopItems = $workflow->addNode('Loop Through Order Items', 'loop', [
            'source_field' => 'items',
        ]);

        $checkStock = $workflow->addNode('Item In Stock?', 'if_condition', [
            'field' => '{{ _loop_item.quantity }}',
            'operator' => 'less_or_equal',
            'value' => '{{ _loop_item.available_stock }}',
        ]);

        $setReserved = $workflow->addNode('Mark as Reserved', 'set_fields', [
            'fields' => [
                'fulfillment_status' => 'reserved',
                'item_name' => '{{ _loop_item.name }}',
                'quantity' => '{{ _loop_item.quantity }}',
            ],
            'keep_existing' => true,
        ]);

        $setBackorder = $workflow->addNode('Mark as Backordered', 'set_fields', [
            'fields' => [
                'fulfillment_status' => 'backordered',
                'item_name' => '{{ _loop_item.name }}',
                'quantity' => '{{ _loop_item.quantity }}',
            ],
            'keep_existing' => true,
        ]);

        $backorderNotify = $workflow->addNode('Backorder Alert', 'send_mail', [
            'send_mode' => 'inline',
            'to' => 'warehouse@shopstation.test',
            'subject' => '⚠️ Backorder: {{ item_name }} for Order #{{ order_number }}',
            'body' => '<p>Item <strong>{{ item_name }}</strong> (qty: {{ quantity }}) is out of stock for Order #{{ order_number }}. Please arrange restocking or notify the customer.</p>',
            'is_html' => true,
        ]);

        $merge = $workflow->addNode('Merge Fulfillment Results', 'merge', [
            'mode' => 'append',
        ]);

        $sendSummary = $workflow->addNode('Send Fulfillment Summary', 'send_mail', [
            'send_mode' => 'inline',
            'to' => 'fulfillment@shopstation.test',
            'subject' => '📦 Fulfillment Summary - Order #{{ order_number }}',
            'body' => '<h3>Fulfillment Summary for Order #{{ order_number }}</h3><p>All line items have been processed. Check the warehouse dashboard for pick-and-pack instructions.</p>',
            'is_html' => true,
        ]);

        $workflow->connect($trigger, $checkStatus);
        $workflow->connect($checkStatus, $setOrderData, 'true', 'main');
        $workflow->connect($setOrderData, $loopItems);
        $workflow->connect($loopItems, $checkStock, 'loop_item', 'main');
        $workflow->connect($checkStock, $setReserved, 'true', 'main');
        $workflow->connect($checkStock, $setBackorder, 'false', 'main');
        $workflow->connect($setBackorder, $backorderNotify);
        $workflow->connect($setReserved, $merge, 'main', 'main_1');
        $workflow->connect($backorderNotify, $merge, 'main', 'main_2');
        $workflow->connect($loopItems, $sendSummary, 'loop_done', 'main');

        $this->command->info('  ✓ Order Fulfillment Pipeline');
    }

    /**
     * 9. Customer Segmentation & VIP Detection
     *
     * Schedule: Weekly → Fetch all customers with orders → Aggregate spend →
     * Filter VIP threshold → Update customer tags → Send VIP welcome
     */
    private function createCustomerSegmentationWorkflow(): void
    {
        $workflow = Workflow::query()->create([
            'name' => 'Weekly Customer Segmentation',
            'description' => 'Runs weekly to analyze customer spending, identify VIP customers (total spend > 100,000), and automatically trigger VIP welcome communications.',
            'is_active' => true,
            'run_async' => true,
            'settings' => [],
            'created_via' => 'code',
            'folder_id' => $this->folders['Customer Engagement']->id,
        ]);

        $workflow->attachTags([
            $this->tags['Customers']->id,
            $this->tags['Reports']->id,
            $this->tags['Marketing']->id,
        ]);

        $trigger = $workflow->addNode('Weekly on Monday 6:00', 'schedule', [
            'interval_type' => 'custom_cron',
            'cron' => '0 6 * * 1',
        ]);

        $fetchCustomers = $workflow->addNode('Fetch Customer Spending', 'run_command', [
            'command_type' => 'artisan',
            'command' => 'tinker',
            'arguments' => [
                '--execute' => 'echo json_encode(\\App\\Models\\User::role("user")->withSum("orders", "total_amount")->get()->map(fn($u) => ["id" => $u->id, "email" => $u->email, "name" => $u->first_name . " " . $u->last_name, "total_spent" => (int) $u->orders_sum_total_amount, "orders_count" => $u->orders()->count()])->toArray());',
            ],
            'include_output' => true,
        ]);

        $parseCustomers = $workflow->addNode('Parse Customer Data', 'parse_data', [
            'source_field' => 'command_result.output',
            'format' => 'json',
            'target_field' => 'customers',
        ]);

        $filterVip = $workflow->addNode('Filter VIP Customers', 'filter', [
            'conditions' => [
                ['field' => 'total_spent', 'operator' => 'greater_than', 'value' => '100000'],
                ['field' => 'orders_count', 'operator' => 'greater_or_equal', 'value' => '3'],
            ],
            'logic' => 'and',
        ]);

        $aggregateStats = $workflow->addNode('VIP Stats Summary', 'aggregate', [
            'operations' => [
                ['field' => 'total_spent', 'function' => 'count', 'alias' => 'vip_count'],
                ['field' => 'total_spent', 'function' => 'sum', 'alias' => 'total_vip_revenue'],
                ['field' => 'total_spent', 'function' => 'avg', 'alias' => 'avg_vip_spend'],
            ],
        ]);

        $loopVips = $workflow->addNode('Loop VIP Customers', 'loop', [
            'source_field' => '_items',
        ]);

        $vipEmail = $workflow->addNode('Send VIP Status Email', 'send_mail', [
            'send_mode' => 'inline',
            'to' => '{{ _loop_item.email }}',
            'subject' => '👑 You\'re a VIP, {{ _loop_item.name }}!',
            'body' => '<h2>Congratulations, {{ _loop_item.name }}!</h2><p>Your loyalty has earned you VIP status at ShopStation. Enjoy exclusive perks including early access to sales, free shipping, and dedicated support.</p>',
            'is_html' => true,
        ]);

        $sendVipReport = $workflow->addNode('Send VIP Report to Management', 'send_mail', [
            'send_mode' => 'inline',
            'to' => 'management@shopstation.test',
            'subject' => '👑 Weekly VIP Customer Report',
            'body' => '<h2>VIP Customer Segment</h2><p><strong>Total VIPs:</strong> {{ vip_count }}</p><p><strong>Combined Revenue:</strong> {{ total_vip_revenue }}</p><p><strong>Average VIP Spend:</strong> {{ avg_vip_spend }}</p>',
            'is_html' => true,
        ]);

        $workflow->connect($trigger, $fetchCustomers);
        $workflow->connect($fetchCustomers, $parseCustomers);
        $workflow->connect($parseCustomers, $filterVip);
        $workflow->connect($filterVip, $aggregateStats);
        $workflow->connect($filterVip, $loopVips);
        $workflow->connect($loopVips, $vipEmail, 'loop_item', 'main');
        $workflow->connect($aggregateStats, $sendVipReport);

        $this->command->info('  ✓ Weekly Customer Segmentation');
    }

    /**
     * 10. External Webhook Inventory Sync
     *
     * Webhook trigger (from external warehouse system) → Parse incoming data →
     * Loop products → Update stock levels → Send sync report
     */
    private function createWebhookInventorySyncWorkflow(): void
    {
        $workflow = Workflow::query()->create([
            'name' => 'Webhook Inventory Sync',
            'description' => 'Receives inventory updates from external warehouse systems via webhook, processes stock level changes, and syncs with the local inventory database.',
            'is_active' => true,
            'run_async' => true,
            'settings' => [],
            'created_via' => 'code',
            'folder_id' => $this->folders['Integrations']->id,
        ]);

        $workflow->attachTags([
            $this->tags['Integrations']->id,
            $this->tags['Inventory']->id,
        ]);

        $trigger = $workflow->addNode('Warehouse Webhook', 'webhook', [
            'method' => 'POST',
            'auth_type' => 'bearer',
        ]);

        $parsePayload = $workflow->addNode('Parse Webhook Body', 'set_fields', [
            'fields' => [
                'warehouse_id' => '{{ body.warehouse_id }}',
                'sync_type' => '{{ body.sync_type }}',
                'products' => '{{ body.products }}',
                'synced_at' => '{{ body.timestamp }}',
            ],
            'keep_existing' => false,
        ]);

        $loopProducts = $workflow->addNode('Loop Products', 'loop', [
            'source_field' => 'products',
        ]);

        $updateStock = $workflow->addNode('Update Product Stock', 'code', [
            'mode' => 'transform',
            'expression' => '["sku" => $item["_loop_item"]["sku"], "new_stock" => $item["_loop_item"]["quantity"], "warehouse" => $item["warehouse_id"], "status" => "synced"]',
        ]);

        $errorHandler = $workflow->addNode('Handle Sync Errors', 'error_handler', [
            'rules' => [
                ['match' => '.*not.found.*', 'route' => 'notify'],
                ['match' => '.*duplicate.*', 'route' => 'ignore'],
                ['match' => '.*', 'route' => 'retry'],
            ],
            'default_route' => 'notify',
        ]);

        $aggregateResults = $workflow->addNode('Sync Summary', 'aggregate', [
            'group_by' => 'status',
            'operations' => [
                ['field' => 'new_stock', 'function' => 'count', 'alias' => 'products_synced'],
                ['field' => 'new_stock', 'function' => 'sum', 'alias' => 'total_units_updated'],
            ],
        ]);

        $sendSyncReport = $workflow->addNode('Send Sync Report', 'send_mail', [
            'send_mode' => 'inline',
            'to' => 'warehouse@shopstation.test',
            'subject' => '📦 Inventory Sync Complete - Warehouse {{ warehouse_id }}',
            'body' => '<h3>Inventory Sync Report</h3><p><strong>Warehouse:</strong> {{ warehouse_id }}</p><p><strong>Products Synced:</strong> {{ products_synced }}</p><p><strong>Total Units Updated:</strong> {{ total_units_updated }}</p><p><strong>Sync Time:</strong> {{ synced_at }}</p>',
            'is_html' => true,
        ]);

        $workflow->connect($trigger, $parsePayload);
        $workflow->connect($parsePayload, $loopProducts);
        $workflow->connect($loopProducts, $updateStock, 'loop_item', 'main');
        $workflow->connect($updateStock, $errorHandler, 'error', 'main');
        $workflow->connect($loopProducts, $aggregateResults, 'loop_done', 'main');
        $workflow->connect($aggregateResults, $sendSyncReport);

        $this->command->info('  ✓ Webhook Inventory Sync');
    }

    /**
     * 11. Refund Processing with Approval Gate
     *
     * Manual trigger → Check refund amount → Small: auto-approve →
     * Large: wait for manager approval → Process refund → Notify customer
     */
    private function createRefundProcessingWorkflow(): void
    {
        $workflow = Workflow::query()->create([
            'name' => 'Refund Processing with Approval',
            'description' => 'Handles refund requests with an approval gate. Small refunds (< 10,000) are auto-approved; larger refunds require manager approval via a wait/resume mechanism.',
            'is_active' => true,
            'run_async' => true,
            'settings' => [],
            'created_via' => 'code',
            'folder_id' => $this->folders['Order Management']->id,
        ]);

        $workflow->attachTags([
            $this->tags['Orders']->id,
            $this->tags['E-Commerce']->id,
        ]);

        $trigger = $workflow->addNode('Refund Requested', 'manual', [
            'input_schema' => [
                'order_id' => 'number',
                'customer_email' => 'string',
                'customer_name' => 'string',
                'refund_amount' => 'number',
                'reason' => 'string',
            ],
        ]);

        $checkAmount = $workflow->addNode('Is Small Refund?', 'if_condition', [
            'field' => '{{ refund_amount }}',
            'operator' => 'less_than',
            'value' => '10000',
        ]);

        $autoApprove = $workflow->addNode('Auto-Approve Refund', 'set_fields', [
            'fields' => [
                'approval_status' => 'approved',
                'approved_by' => 'system',
            ],
            'keep_existing' => true,
        ]);

        $notifyManager = $workflow->addNode('Notify Manager for Approval', 'send_mail', [
            'send_mode' => 'inline',
            'to' => 'manager@shopstation.test',
            'subject' => '🔐 Refund Approval Required - Order #{{ order_id }} ({{ refund_amount }})',
            'body' => '<h3>Refund Requires Approval</h3><p><strong>Order:</strong> #{{ order_id }}</p><p><strong>Customer:</strong> {{ customer_name }} ({{ customer_email }})</p><p><strong>Amount:</strong> {{ refund_amount }}</p><p><strong>Reason:</strong> {{ reason }}</p><p>Please approve or reject this refund via the admin panel.</p>',
            'is_html' => true,
        ]);

        $waitApproval = $workflow->addNode('Wait for Manager Approval', 'wait_resume', [
            'timeout_seconds' => 172800,
        ]);

        $checkApproval = $workflow->addNode('Was Approved?', 'if_condition', [
            'field' => '{{ approval_status }}',
            'operator' => 'equals',
            'value' => 'approved',
        ]);

        $processRefund = $workflow->addNode('Process Refund', 'http_request', [
            'url' => 'https://api.stripe.com/v1/refunds',
            'method' => 'POST',
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'body' => '{"charge": "{{ stripe_charge_id }}", "amount": {{ refund_amount }}}',
            'timeout' => 30,
        ]);

        $sendConfirmation = $workflow->addNode('Send Refund Confirmation', 'send_mail', [
            'send_mode' => 'inline',
            'to' => '{{ customer_email }}',
            'subject' => '✅ Refund Processed - Order #{{ order_id }}',
            'body' => '<h3>Your refund has been processed</h3><p>Hi {{ customer_name }},</p><p>Your refund of {{ refund_amount }} for Order #{{ order_id }} has been processed. Please allow 5-10 business days for the amount to appear in your account.</p>',
            'is_html' => true,
        ]);

        $sendRejection = $workflow->addNode('Send Rejection Notice', 'send_mail', [
            'send_mode' => 'inline',
            'to' => '{{ customer_email }}',
            'subject' => 'Refund Update - Order #{{ order_id }}',
            'body' => '<p>Hi {{ customer_name }},</p><p>After reviewing your refund request for Order #{{ order_id }}, we\'re unable to process the refund at this time. Please contact support for more details.</p>',
            'is_html' => true,
        ]);

        $timeoutNotify = $workflow->addNode('Approval Timeout Alert', 'send_mail', [
            'send_mode' => 'inline',
            'to' => 'manager@shopstation.test',
            'subject' => '⏰ Refund Approval Expired - Order #{{ order_id }}',
            'body' => '<p>The refund approval for Order #{{ order_id }} ({{ refund_amount }}) has expired after 48 hours without a decision. Please review immediately.</p>',
            'is_html' => true,
        ]);

        // Small refund: auto-approve → process → confirm
        $workflow->connect($trigger, $checkAmount);
        $workflow->connect($checkAmount, $autoApprove, 'true', 'main');
        $workflow->connect($autoApprove, $processRefund);
        $workflow->connect($processRefund, $sendConfirmation);

        // Large refund: notify manager → wait → check decision
        $workflow->connect($checkAmount, $notifyManager, 'false', 'main');
        $workflow->connect($notifyManager, $waitApproval);
        $workflow->connect($waitApproval, $checkApproval, 'resume', 'main');
        $workflow->connect($waitApproval, $timeoutNotify, 'timeout', 'main');
        $workflow->connect($checkApproval, $processRefund, 'true', 'main');
        $workflow->connect($checkApproval, $sendRejection, 'false', 'main');

        $this->command->info('  ✓ Refund Processing with Approval');
    }

    /**
     * 12. New Product Catalog Publish with Multi-Channel Sync
     *
     * Trigger: Product created → Enrich data → HTTP request to sync with external marketplace →
     * Send Slack/email notification → Sub-workflow for SEO check
     */
    private function createNewProductCatalogPublishWorkflow(): void
    {
        $workflow = Workflow::query()->create([
            'name' => 'Product Catalog Multi-Channel Publish',
            'description' => 'When a new product is published, syncs it to external marketplaces via API, runs AI-powered SEO analysis, and notifies the marketing team across channels.',
            'is_active' => true,
            'run_async' => true,
            'settings' => [],
            'created_via' => 'code',
            'folder_id' => $this->folders['Inventory']->id,
        ]);

        $workflow->attachTags([
            $this->tags['E-Commerce']->id,
            $this->tags['Integrations']->id,
            $this->tags['Marketing']->id,
        ]);

        $trigger = $workflow->addNode('Product Published', 'model_event', [
            'model' => 'App\\Models\\Product',
            'events' => ['created'],
        ]);

        $enrichProduct = $workflow->addNode('Prepare Product Data', 'set_fields', [
            'fields' => [
                'product_id' => '{{ model.id }}',
                'product_name' => '{{ model.name }}',
                'product_slug' => '{{ model.slug }}',
                'product_sku' => '{{ model.sku }}',
                'product_description' => '{{ model.description }}',
                'is_visible' => '{{ model.is_visible }}',
            ],
            'keep_existing' => true,
        ]);

        $checkVisible = $workflow->addNode('Is Product Visible?', 'if_condition', [
            'field' => '{{ is_visible }}',
            'operator' => 'equals',
            'value' => 'true',
        ]);

        $syncMarketplace = $workflow->addNode('Sync to External Marketplace', 'http_request', [
            'url' => 'https://marketplace-api.example.com/v1/products',
            'method' => 'POST',
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'body' => '{"name": "{{ product_name }}", "sku": "{{ product_sku }}", "description": "{{ product_description }}", "source": "shopstation"}',
            'timeout' => 30,
            'include_response' => true,
        ]);

        $aiSeoCheck = $workflow->addNode('AI SEO Analysis', 'ai', [
            'prompt' => 'Analyze this product listing for SEO quality. Product: "{{ product_name }}" Description: "{{ product_description }}" Slug: "{{ product_slug }}". Score it 1-10 and provide 3 specific improvement suggestions. Respond as JSON: {"score": N, "suggestions": ["...", "...", "..."]}',
            'system_prompt' => 'You are an e-commerce SEO specialist. Evaluate product listings for search engine optimization quality including title keywords, description completeness, and URL slug quality.',
            'provider' => 'anthropic',
            'model' => 'claude-haiku-4-5-20251001',
            'temperature' => '0.3',
            'max_tokens' => 300,
            'output_key' => 'seo_analysis',
        ]);

        $parseSeo = $workflow->addNode('Parse SEO Results', 'parse_data', [
            'source_field' => 'seo_analysis',
            'format' => 'json',
            'target_field' => 'seo_data',
        ]);

        $merge = $workflow->addNode('Merge Results', 'merge', [
            'mode' => 'wait_all',
        ]);

        $notifyTeam = $workflow->addNode('Notify Marketing Team', 'send_mail', [
            'send_mode' => 'inline',
            'to' => 'marketing@shopstation.test',
            'subject' => '🆕 New Product Published: {{ product_name }}',
            'body' => '<h3>New Product Available</h3><p><strong>{{ product_name }}</strong> (SKU: {{ product_sku }}) has been published and synced to external marketplaces.</p><p><strong>SEO Score:</strong> {{ seo_data.score }}/10</p><h4>SEO Suggestions:</h4><ul><li>Review the product listing for suggested improvements</li></ul>',
            'is_html' => true,
        ]);

        $errorHandler = $workflow->addNode('Handle Sync Errors', 'error_handler', [
            'rules' => [
                ['match' => '.*timeout.*', 'route' => 'retry'],
                ['match' => '.*401.*', 'route' => 'notify'],
                ['match' => '.*5\\d{2}.*', 'route' => 'retry'],
            ],
            'default_route' => 'notify',
        ]);

        $errorNotify = $workflow->addNode('Alert: Sync Failed', 'send_mail', [
            'send_mode' => 'inline',
            'to' => 'devops@shopstation.test',
            'subject' => '❌ Marketplace Sync Failed - {{ product_name }}',
            'body' => '<p>Failed to sync product <strong>{{ product_name }}</strong> (SKU: {{ product_sku }}) to the external marketplace. Please investigate.</p>',
            'is_html' => true,
        ]);

        $workflow->connect($trigger, $enrichProduct);
        $workflow->connect($enrichProduct, $checkVisible);
        $workflow->connect($checkVisible, $syncMarketplace, 'true', 'main');
        $workflow->connect($checkVisible, $aiSeoCheck, 'true', 'main');
        $workflow->connect($syncMarketplace, $merge, 'main', 'main_1');
        $workflow->connect($syncMarketplace, $errorHandler, 'error', 'main');
        $workflow->connect($errorHandler, $errorNotify, 'notify', 'main');
        $workflow->connect($aiSeoCheck, $parseSeo);
        $workflow->connect($parseSeo, $merge, 'main', 'main_2');
        $workflow->connect($merge, $notifyTeam);

        $this->command->info('  ✓ Product Catalog Multi-Channel Publish');
    }
}
