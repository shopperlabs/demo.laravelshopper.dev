<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to enhance the user's satisfaction building Laravel applications.

## Foundational Context
This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.4.17
- filament/filament (FILAMENT) - v4
- laravel/framework (LARAVEL) - v11
- laravel/prompts (PROMPTS) - v0
- livewire/livewire (LIVEWIRE) - v3
- livewire/volt (VOLT) - v1
- larastan/larastan (LARASTAN) - v2
- laravel/breeze (BREEZE) - v2
- laravel/mcp (MCP) - v0
- laravel/pint (PINT) - v1
- pestphp/pest (PEST) - v2
- phpunit/phpunit (PHPUNIT) - v10
- prettier (PRETTIER) - v3
- tailwindcss (TAILWINDCSS) - v3

## Conventions
- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts
- Do not create verification scripts or tinker when tests cover that functionality and prove it works. Unit and feature tests are more important.

## Application Structure & Architecture
- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling
- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Replies
- Be concise in your explanations - focus on what's important rather than explaining obvious details.

## Documentation Files
- You must only create documentation files if explicitly requested by the user.

=== boost rules ===

## Laravel Boost
- Laravel Boost is an MCP server that comes with powerful tools designed specifically for this application. Use them.

## Artisan
- Use the `list-artisan-commands` tool when you need to call an Artisan command to double-check the available parameters.

## URLs
- Whenever you share a project URL with the user, you should use the `get-absolute-url` tool to ensure you're using the correct scheme, domain/IP, and port.

## Tinker / Debugging
- You should use the `tinker` tool when you need to execute PHP to debug code or query Eloquent models directly.
- Use the `database-query` tool when you only need to read from the database.

## Reading Browser Logs With the `browser-logs` Tool
- You can read browser logs, errors, and exceptions using the `browser-logs` tool from Boost.
- Only recent browser logs will be useful - ignore old logs.

## Searching Documentation (Critically Important)
- Boost comes with a powerful `search-docs` tool you should use before any other approaches when dealing with Laravel or Laravel ecosystem packages. This tool automatically passes a list of installed packages and their versions to the remote Boost API, so it returns only version-specific documentation for the user's circumstance. You should pass an array of packages to filter on if you know you need docs for particular packages.
- The `search-docs` tool is perfect for all Laravel-related packages, including Laravel, Inertia, Livewire, Filament, Tailwind, Pest, Nova, Nightwatch, etc.
- You must use this tool to search for Laravel ecosystem documentation before falling back to other approaches.
- Search the documentation before making code changes to ensure we are taking the correct approach.
- Use multiple, broad, simple, topic-based queries to start. For example: `['rate limiting', 'routing rate limiting', 'routing']`.
- Do not add package names to queries; package information is already shared. For example, use `test resource table`, not `filament 4 test resource table`.

### Available Search Syntax
- You can and should pass multiple queries at once. The most relevant results will be returned first.

1. Simple Word Searches with auto-stemming - query=authentication - finds 'authenticate' and 'auth'.
2. Multiple Words (AND Logic) - query=rate limit - finds knowledge containing both "rate" AND "limit".
3. Quoted Phrases (Exact Position) - query="infinite scroll" - words must be adjacent and in that order.
4. Mixed Queries - query=middleware "rate limit" - "middleware" AND exact phrase "rate limit".
5. Multiple Queries - queries=["authentication", "middleware"] - ANY of these terms.

=== php rules ===

## PHP

- Always use strict typing at the head of a `.php` file: `declare(strict_types=1);`.
- Always use curly braces for control structures, even if it has one line.

### Constructors
- Use PHP 8 constructor property promotion in `__construct()`.
    - <code-snippet>public function __construct(public GitHub $github) { }</code-snippet>
- Do not allow empty `__construct()` methods with zero parameters unless the constructor is private.

### Type Declarations
- Always use explicit return type declarations for methods and functions.
- Use appropriate PHP type hints for method parameters.

<code-snippet name="Explicit Return Types and Method Params" lang="php">
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
</code-snippet>

## Comments
- Prefer PHPDoc blocks over inline comments. Never use comments within the code itself unless there is something very complex going on.

## PHPDoc Blocks
- Add useful array shape type definitions for arrays when appropriate.

## Enums
- Typically, keys in an Enum should be TitleCase. For example: `FavoritePerson`, `BestLake`, `Monthly`.

=== herd rules ===

## Laravel Herd

- The application is served by Laravel Herd and will be available at: `https?://[kebab-case-project-dir].test`. Use the `get-absolute-url` tool to generate URLs for the user to ensure valid URLs.
- You must not run any commands to make the site available via HTTP(S). It is always available through Laravel Herd.

=== tests rules ===

## Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test --compact` with a specific filename or filter.

=== laravel/core rules ===

## Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using the `list-artisan-commands` tool.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Database
- Always use proper Eloquent relationship methods with return type hints. Prefer relationship methods over raw queries or manual joins.
- Use Eloquent models and relationships before suggesting raw database queries.
- Avoid `DB::`; prefer `Model::query()`. Generate code that leverages Laravel's ORM capabilities rather than bypassing them.
- Generate code that prevents N+1 query problems by using eager loading.
- Use Laravel's query builder for very complex database operations.

### Model Creation
- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `list-artisan-commands` to check the available options to `php artisan make:model`.

### APIs & Eloquent Resources
- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

### Controllers & Validation
- Always create Form Request classes for validation rather than inline validation in controllers. Include both validation rules and custom error messages.
- Check sibling Form Requests to see if the application uses array or string based validation rules.

### Queues
- Use queued jobs for time-consuming operations with the `ShouldQueue` interface.

### Authentication & Authorization
- Use Laravel's built-in authentication and authorization features (gates, policies, Sanctum, etc.).

### URL Generation
- When generating links to other pages, prefer named routes and the `route()` function.

### Configuration
- Use environment variables only in configuration files - never use the `env()` function directly outside of config files. Always use `config('app.name')`, not `env('APP_NAME')`.

### Testing
- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

### Vite Error
- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== laravel/v11 rules ===

## Laravel 11

- Use the `search-docs` tool to get version-specific documentation.
- Laravel 11 brought a new streamlined file structure which this project now uses.

### Laravel 11 Structure
- In Laravel 11, middleware are no longer registered in `app/Http/Kernel.php`.
- Middleware are configured declaratively in `bootstrap/app.php` using `Application::configure()->withMiddleware()`.
- `bootstrap/app.php` is the file to register middleware, exceptions, and routing files.
- `bootstrap/providers.php` contains application specific service providers.
- **No app\Console\Kernel.php** - use `bootstrap/app.php` or `routes/console.php` for console configuration.
- **Commands auto-register** - files in `app/Console/Commands/` are automatically available and do not require manual registration.

### Database
- When modifying a column, the migration must include all of the attributes that were previously defined on the column. Otherwise, they will be dropped and lost.
- Laravel 11 allows limiting eagerly loaded records natively, without external packages: `$query->latest()->limit(10);`.

### Models
- Casts can and likely should be set in a `casts()` method on a model rather than the `$casts` property. Follow existing conventions from other models.

### New Artisan Commands
- List Artisan commands using Boost's MCP tool, if available. New commands available in Laravel 11:
    - `php artisan make:enum`
    - `php artisan make:class`
    - `php artisan make:interface`

=== livewire/core rules ===

## Livewire

- Use the `search-docs` tool to find exact version-specific documentation for how to write Livewire and Livewire tests.
- Use the `php artisan make:livewire [Posts\CreatePost]` Artisan command to create new components.
- State should live on the server, with the UI reflecting it.
- All Livewire requests hit the Laravel backend; they're like regular HTTP requests. Always validate form data and run authorization checks in Livewire actions.

## Livewire Best Practices
- Livewire components require a single root element.
- Use `wire:loading` and `wire:dirty` for delightful loading states.
- Add `wire:key` in loops:

    ```blade
    @foreach ($items as $item)
        <div wire:key="item-{{ $item->id }}">
            {{ $item->name }}
        </div>
    @endforeach
    ```

- Prefer lifecycle hooks like `mount()`, `updatedFoo()` for initialization and reactive side effects:

<code-snippet name="Lifecycle Hook Examples" lang="php">
    public function mount(User $user) { $this->user = $user; }
    public function updatedSearch() { $this->resetPage(); }
</code-snippet>

## Testing Livewire

<code-snippet name="Example Livewire Component Test" lang="php">
    Livewire::test(Counter::class)
        ->assertSet('count', 0)
        ->call('increment')
        ->assertSet('count', 1)
        ->assertSee(1)
        ->assertStatus(200);
</code-snippet>

<code-snippet name="Testing Livewire Component Exists on Page" lang="php">
    $this->get('/posts/create')
    ->assertSeeLivewire(CreatePost::class);
</code-snippet>

=== livewire/v3 rules ===

## Livewire 3

### Key Changes From Livewire 2
- These things changed in Livewire 3, but may not have been updated in this application. Verify this application's setup to ensure you conform with application conventions.
    - Use `wire:model.live` for real-time updates, `wire:model` is now deferred by default.
    - Components now use the `App\Livewire` namespace (not `App\Http\Livewire`).
    - Use `$this->dispatch()` to dispatch events (not `emit` or `dispatchBrowserEvent`).
    - Use the `components.layouts.app` view as the typical layout path (not `layouts.app`).

### New Directives
- `wire:show`, `wire:transition`, `wire:cloak`, `wire:offline`, `wire:target` are available for use. Use the documentation to find usage examples.

### Alpine
- Alpine is now included with Livewire; don't manually include Alpine.js.
- Plugins included with Alpine: persist, intersect, collapse, and focus.

### Lifecycle Hooks
- You can listen for `livewire:init` to hook into Livewire initialization, and `fail.status === 419` for the page expiring:

<code-snippet name="Livewire Init Hook Example" lang="js">
document.addEventListener('livewire:init', function () {
    Livewire.hook('request', ({ fail }) => {
        if (fail && fail.status === 419) {
            alert('Your session expired');
        }
    });

    Livewire.hook('message.failed', (message, component) => {
        console.error(message);
    });
});
</code-snippet>

=== volt/core rules ===

## Livewire Volt

- This project uses Livewire Volt for interactivity within its pages. New pages requiring interactivity must also use Livewire Volt.
- Make new Volt components using `php artisan make:volt [name] [--test] [--pest]`.
- Volt is a class-based and functional API for Livewire that supports single-file components, allowing a component's PHP logic and Blade templates to coexist in the same file.
- Livewire Volt allows PHP logic and Blade templates in one file. Components use the `@volt` directive.
- You must check existing Volt components to determine if they're functional or class-based. If you can't detect that, ask the user which they prefer before writing a Volt component.

### Volt Functional Component Example

<code-snippet name="Volt Functional Component Example" lang="php">
@volt
<?php
use function Livewire\Volt\{state, computed};

state(['count' => 0]);

$increment = fn () => $this->count++;
$decrement = fn () => $this->count--;

$double = computed(fn () => $this->count * 2);
?>

<div>
    <h1>Count: {{ $count }}</h1>
    <h2>Double: {{ $this->double }}</h2>
    <button wire:click="increment">+</button>
    <button wire:click="decrement">-</button>
</div>
@endvolt
</code-snippet>

### Volt Class Based Component Example
To get started, define an anonymous class that extends Livewire\Volt\Component. Within the class, you may utilize all of the features of Livewire using traditional Livewire syntax:

<code-snippet name="Volt Class-based Volt Component Example" lang="php">
use Livewire\Volt\Component;

new class extends Component {
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }
} ?>

<div>
    <h1>{{ $count }}</h1>
    <button wire:click="increment">+</button>
</div>
</code-snippet>

### Testing Volt & Volt Components
- Use the existing directory for tests if it already exists. Otherwise, fallback to `tests/Feature/Volt`.

<code-snippet name="Livewire Test Example" lang="php">
use Livewire\Volt\Volt;

test('counter increments', function () {
    Volt::test('counter')
        ->assertSee('Count: 0')
        ->call('increment')
        ->assertSee('Count: 1');
});
</code-snippet>

<code-snippet name="Volt Component Test Using Pest" lang="php">
declare(strict_types=1);

use App\Models\{User, Product};
use Livewire\Volt\Volt;

test('product form creates product', function () {
    $user = User::factory()->create();

    Volt::test('pages.products.create')
        ->actingAs($user)
        ->set('form.name', 'Test Product')
        ->set('form.description', 'Test Description')
        ->set('form.price', 99.99)
        ->call('create')
        ->assertHasNoErrors();

    expect(Product::where('name', 'Test Product')->exists())->toBeTrue();
});
</code-snippet>

### Common Patterns

<code-snippet name="CRUD With Volt" lang="php">
<?php

use App\Models\Product;
use function Livewire\Volt\{state, computed};

state(['editing' => null, 'search' => '']);

$products = computed(fn() => Product::when($this->search,
    fn($q) => $q->where('name', 'like', "%{$this->search}%")
)->get());

$edit = fn(Product $product) => $this->editing = $product->id;
$delete = fn(Product $product) => $product->delete();

?>

<!-- HTML / UI Here -->
</code-snippet>

<code-snippet name="Real-Time Search With Volt" lang="php">
    <flux:input
        wire:model.live.debounce.300ms="search"
        placeholder="Search..."
    />
</code-snippet>

<code-snippet name="Loading States With Volt" lang="php">
    <flux:button wire:click="save" wire:loading.attr="disabled">
        <span wire:loading.remove>Save</span>
        <span wire:loading>Saving...</span>
    </flux:button>
</code-snippet>

=== pint/core rules ===

## Laravel Pint Code Formatter

- You must run `vendor/bin/pint --dirty` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test`, simply run `vendor/bin/pint` to fix any formatting issues.

=== pest/core rules ===

## Pest
### Testing
- If you need to verify a feature is working, write or update a Unit / Feature test.

### Pest Tests
- All tests must be written using Pest. Use `php artisan make:test --pest {name}`.
- You must not remove any tests or test files from the tests directory without approval. These are not temporary or helper files - these are core to the application.
- Tests should test all of the happy paths, failure paths, and weird paths.
- Tests live in the `tests/Feature` and `tests/Unit` directories.
- Pest tests look and behave like this:
<code-snippet name="Basic Pest Test Example" lang="php">
it('is true', function () {
    expect(true)->toBeTrue();
});
</code-snippet>

### Running Tests
- Run the minimal number of tests using an appropriate filter before finalizing code edits.
- To run all tests: `php artisan test --compact`.
- To run all tests in a file: `php artisan test --compact tests/Feature/ExampleTest.php`.
- To filter on a particular test name: `php artisan test --compact --filter=testName` (recommended after making a change to a related file).
- When the tests relating to your changes are passing, ask the user if they would like to run the entire test suite to ensure everything is still passing.

### Pest Assertions
- When asserting status codes on a response, use the specific method like `assertForbidden` and `assertNotFound` instead of using `assertStatus(403)` or similar, e.g.:
<code-snippet name="Pest Example Asserting postJson Response" lang="php">
it('returns all', function () {
    $response = $this->postJson('/api/docs', []);

    $response->assertSuccessful();
});
</code-snippet>

### Mocking
- Mocking can be very helpful when appropriate.
- When mocking, you can use the `Pest\Laravel\mock` Pest function, but always import it via `use function Pest\Laravel\mock;` before using it. Alternatively, you can use `$this->mock()` if existing tests do.
- You can also create partial mocks using the same import or self method.

### Datasets
- Use datasets in Pest to simplify tests that have a lot of duplicated data. This is often the case when testing validation rules, so consider this solution when writing tests for validation rules.

<code-snippet name="Pest Dataset Example" lang="php">
it('has emails', function (string $email) {
    expect($email)->not->toBeEmpty();
})->with([
    'james' => 'james@laravel.com',
    'taylor' => 'taylor@laravel.com',
]);
</code-snippet>

=== tailwindcss/core rules ===

## Tailwind CSS

- Use Tailwind CSS classes to style HTML; check and use existing Tailwind conventions within the project before writing your own.
- Offer to extract repeated patterns into components that match the project's conventions (i.e. Blade, JSX, Vue, etc.).
- Think through class placement, order, priority, and defaults. Remove redundant classes, add classes to parent or child carefully to limit repetition, and group elements logically.
- You can use the `search-docs` tool to get exact examples from the official documentation when needed.

### Spacing
- When listing items, use gap utilities for spacing; don't use margins.

<code-snippet name="Valid Flex Gap Spacing Example" lang="html">
    <div class="flex gap-8">
        <div>Superior</div>
        <div>Michigan</div>
        <div>Erie</div>
    </div>
</code-snippet>

### Dark Mode
- If existing pages and components support dark mode, new pages and components must support dark mode in a similar way, typically using `dark:`.

=== tailwindcss/v3 rules ===

## Tailwind CSS 3

- Always use Tailwind CSS v3; verify you're using only classes supported by this version.

=== shopper/framework rules ===

## Laravel Shopper

Laravel Shopper is a headless e-commerce framework providing a complete admin panel built with Filament and Livewire. For detailed documentation, refer to https://docs.laravelshopper.dev

### Installation

- Use `composer require shopper/framework --with-dependencies` to install Shopper.
- Run `php artisan shopper:install` to publish config, migrations, and assets.
- Run `php artisan shopper:user` to create an admin user.
- The admin panel is accessible at `/cpanel` by default (configurable via `SHOPPER_PREFIX` env variable).

### Configuration

Configuration files are published to `config/shopper/`:

- `admin.php` - Admin panel prefix, domain, and custom pages namespace/path
- `core.php` - Table prefix (default: `sh_`), roles
- `models.php` - Model bindings for customization
- `features.php` - Enable/disable features (attributes, collections, reviews, discounts)
- `media.php` - Media storage settings (Spatie Media Library)
- `orders.php` - Order number generation
- `routes.php` - Custom routes and middleware
- `components/` - Component overrides by feature

### Creating Custom Admin Pages

Use `php artisan make:shopper-page {PageName}` to create a new page in the admin panel. This creates:
- A Livewire component in `App\Livewire\Shopper` namespace (configurable in `config/shopper/admin.php`)
- A Blade view in `resources/views/livewire/shopper`

<code-snippet name="Create a custom Shopper page with table" lang="php">
// Run: php artisan make:shopper-page Shipping

// app/Livewire/Shopper/Shipping.php
namespace App\Livewire\Shopper;

use App\Models\ShippingMethod;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Shopper\Livewire\Pages\AbstractPageComponent;

class Shipping extends AbstractPageComponent implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function mount(): void
    {
        $this->authorize('browse_shipping'); // Optional authorization
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(ShippingMethod::query())
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label(__('Price'))
                    ->money('USD'),
                TextColumn::make('is_enabled')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray'),
            ]);
    }

    public function render(): View
    {
        return view('livewire.shopper.shipping');
    }
}
</code-snippet>

<code-snippet name="Blade view for custom page" lang="blade">
{{-- resources/views/livewire/shopper/shipping.blade.php --}}
<x-shopper::container>
    <x-shopper::breadcrumb :back="route('shopper.settings.index')" :current="__('Shipping Methods')">
        <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" />
        <x-shopper::breadcrumb.link :link="route('shopper.settings.index')" :title="__('Settings')" />
    </x-shopper::breadcrumb>

    <x-shopper::heading class="my-6" :title="__('Shipping Methods')" />

    <x-shopper::card class="mt-5">
        {{ $this->table }}
    </x-shopper::card>
</x-shopper::container>
</code-snippet>

### Registering Custom Routes

After creating a page, register its route in `routes/shopper.php`:

<code-snippet name="Register custom page route" lang="php">
// config/shopper/routes.php
return [
    'custom_file' => base_path('routes/shopper.php'),
];

// routes/shopper.php
use App\Livewire\Shopper\Shipping;
use Illuminate\Support\Facades\Route;

Route::get('shipping', Shipping::class)->name('shopper.shipping.index');
</code-snippet>

### Sidebar Navigation System

Shopper uses a sidebar system with 4 default groups. Each group is a class extending `AbstractAdminSidebar`:

- `DashboardSidebar` - Dashboard menu (weight: 1, no heading)
- `CatalogSidebar` - Products, Categories, Collections, Brands (weight: 2)
- `SalesSidebar` - Orders, Discounts (weight: 3)
- `CustomerSidebar` - Customers, Reviews (weight: 4)

Groups with the same name are automatically merged. Groups without a name (empty string or omitted) are merged with the Dashboard group.

To add items to an existing sidebar group or create a new one, create a sidebar extender class:

<code-snippet name="Create sidebar extender to add menu item" lang="php">
// app/Sidebar/ShippingSidebar.php
namespace App\Sidebar;

use Shopper\Sidebar\AbstractAdminSidebar;
use Shopper\Sidebar\Contracts\Builder\Group;
use Shopper\Sidebar\Contracts\Builder\Item;
use Shopper\Sidebar\Contracts\Builder\Menu;

class ShippingSidebar extends AbstractAdminSidebar
{
    public function extendWith(Menu $menu): Menu
    {
        // Add to existing "Catalog" group
        $menu->group(__('shopper::layout.sidebar.catalog'), function (Group $group): void {
            $group->weight(2); // Same weight as CatalogSidebar to merge

            $group->item(__('Shipping Methods'), function (Item $item): void {
                $item->weight(5); // Position after other items
                $item->useSpa(); // Enable SPA navigation
                $item->route('shopper.shipping.index');
                $item->setIcon('untitledui-truck-01');
            });
        });

        return $menu;
    }
}
</code-snippet>

<code-snippet name="Register sidebar extender in ServiceProvider" lang="php">
// app/Providers/AppServiceProvider.php
namespace App\Providers;

use App\Sidebar\ShippingSidebar;
use Illuminate\Support\ServiceProvider;
use Shopper\Sidebar\SidebarBuilder;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register the sidebar extender
        $this->app['events']->listen(SidebarBuilder::class, ShippingSidebar::class);
    }
}
</code-snippet>

### Creating a New Sidebar Group

To create a completely new sidebar group instead of adding to an existing one:

<code-snippet name="Create new sidebar group" lang="php">
// app/Sidebar/CustomSidebar.php
namespace App\Sidebar;

use Shopper\Sidebar\AbstractAdminSidebar;
use Shopper\Sidebar\Contracts\Builder\Group;
use Shopper\Sidebar\Contracts\Builder\Item;
use Shopper\Sidebar\Contracts\Builder\Menu;

class CustomSidebar extends AbstractAdminSidebar
{
    public function extendWith(Menu $menu): Menu
    {
        $menu->group(__('Logistics'), function (Group $group): void {
            $group->weight(5); // After CustomerSidebar (weight 4)
            $group->setAuthorized();

            $group->item(__('Shipping'), function (Item $item): void {
                $item->weight(1);
                $item->setAuthorized($this->user->hasPermissionTo('browse_shipping'));
                $item->useSpa();
                $item->route('shopper.shipping.index');
                $item->setIcon('untitledui-truck-01');
            });

            $group->item(__('Carriers'), function (Item $item): void {
                $item->weight(2);
                $item->useSpa();
                $item->route('shopper.carriers.index');
                $item->setIcon('untitledui-plane');
            });
        });

        return $menu;
    }
}
</code-snippet>

### Adding Items to the Dashboard Group (No Heading)

To add items alongside the Dashboard (without a group heading), omit the group name:

<code-snippet name="Add item to dashboard group" lang="php">
$menu->group(function (Group $group): void {
    $group->weight(1);
    $group->setAuthorized();

    $group->item(__('Analytics'), function (Item $item): void {
        $item->weight(2); // After Dashboard (weight 1)
        $item->useSpa();
        $item->route('shopper.analytics.index');
        $item->setIcon('phosphor-chart-line');
    });
});
</code-snippet>

### Sidebar Item Options

When configuring sidebar items, use these methods:

- `$item->weight(int)` - Position in group (lower = higher)
- `$item->setAuthorized(bool)` - Show/hide based on condition (use `$this->user->hasPermissionTo()`)
- `$item->useSpa()` - Enable SPA navigation with `wire:navigate`
- `$item->route('route.name')` - Set the route
- `$item->setIcon(icon, iconClass, attributes)` - Configure icon (use Untitled UI icons: `untitledui-*`)
- `$item->setItemClass()`, `$item->setActiveClass()` - CSS classes
- `$item->item()` - Add nested sub-items

### Model Architecture

All models use contracts and can be resolved from the container. Always use contracts when type-hinting:

<code-snippet name="Resolve Shopper models via contracts" lang="php">
use Shopper\Core\Models\Contracts\Product as ProductContract;
use Shopper\Core\Models\Contracts\Order as OrderContract;
use Shopper\Core\Models\Contracts\Category as CategoryContract;

// In a controller or service
public function __construct(
    private ProductContract $productModel,
) {}

// Query products
$products = resolve(ProductContract::class)::query()
    ->where('is_visible', true)
    ->get();
</code-snippet>

### Custom Models

To extend Shopper models, create your own model extending the base and update `config/shopper/models.php`:

<code-snippet name="Create and register custom model" lang="php">
// app/Models/Product.php
namespace App\Models;

use Shopper\Core\Models\Product as ShopperProduct;

class Product extends ShopperProduct
{
    public function customRelation()
    {
        return $this->hasMany(CustomModel::class);
    }
}

// config/shopper/models.php
return [
    'product' => App\Models\Product::class,
];
</code-snippet>

### Product Types

Products have types that determine capabilities. Use the `ProductType` enum:

- `ProductType::Standard` - Physical products with shipping, supports variants
- `ProductType::Variant` - Product with variants (sizes, colors)
- `ProductType::Virtual` - Digital products, no shipping, no variants
- `ProductType::External` - Affiliate products, no shipping, no variants

Check capabilities with: `$product->canUseVariants()`, `$product->canUseShipping()`, `$product->isVirtual()`

### Stock Management

Products and variants use the `HasStock` trait. Shopper supports multi-location inventory:

<code-snippet name="Manage inventory stock" lang="php">
use Shopper\Core\Models\Product;
use Shopper\Core\Models\Inventory;

$product = Product::query()->find($id);
$inventory = Inventory::query()->where('is_default', true)->first();

$product->setStock(100, $inventory->id);
$product->decreaseStock($inventory->id, 5);
$currentStock = $product->getStock();
</code-snippet>

### Pricing

Products support multi-currency pricing. Amounts are stored in cents:

<code-snippet name="Create product price" lang="php">
use Shopper\Core\Models\Currency;

$product->prices()->create([
    'currency_id' => Currency::where('code', 'USD')->first()->id,
    'amount' => 2999,         // .99
    'compare_amount' => 3999, // .99 (crossed-out price)
    'cost_amount' => 1500,    // .00 (cost for profit calc)
]);
</code-snippet>

### Categories

Categories support hierarchical structures using LaravelAdjacencyList:

<code-snippet name="Work with category hierarchy" lang="php">
$category->children;              // Direct children
$category->descendantCategories(); // All descendants
$category->parent;                // Parent category
$category->ancestors;             // All ancestors
</code-snippet>

### Orders

Orders track purchases with statuses. Use the `OrderStatus` enum:

- `OrderStatus::Pending`, `OrderStatus::Register`, `OrderStatus::Paid`
- `OrderStatus::Shipped`, `OrderStatus::Completed`, `OrderStatus::Cancelled`

<code-snippet name="Query orders with relationships" lang="php">
use Shopper\Core\Models\Order;
use Shopper\Core\Enum\OrderStatus;

$orders = Order::with(['items', 'customer', 'shippingAddress', 'zone'])
    ->where('status', OrderStatus::Pending)
    ->get();
</code-snippet>

### Events

Shopper dispatches events for major actions. Listen to these for custom logic:

- Products: `ProductCreated`, `ProductUpdated`, `ProductDeleted`
- Orders: `OrderCreated`, `OrderCompleted`, `OrderPaid`, `OrderCancel`, `OrderArchived`

<code-snippet name="Listen to Shopper events" lang="php">
use Shopper\Core\Events\Products\ProductCreated;
use Shopper\Core\Events\Orders\OrderCreated;

// In EventServiceProvider
protected $listen = [
    ProductCreated::class => [YourListener::class],
    OrderCreated::class => [SendOrderConfirmation::class],
];
</code-snippet>

### Extending Navigation (Simple Method)

For quick sidebar customization, use a closure in your ServiceProvider:

<code-snippet name="Add sidebar item with closure" lang="php">
// app/Providers/AppServiceProvider.php
use Illuminate\Support\Facades\Event;
use Shopper\Sidebar\Contracts\Builder\Group;
use Shopper\Sidebar\Contracts\Builder\Item;
use Shopper\Sidebar\SidebarBuilder;

public function boot(): void
{
    Event::listen(SidebarBuilder::class, function (SidebarBuilder $sidebar) {
        $sidebar->add(
            $sidebar->getMenu()->group('Custom Section', function (Group $group) {
                $group->weight(50);
                $group->setAuthorized();

                $group->item('My Custom Page', function (Item $item) {
                    $item->weight(1);
                    $item->useSpa();
                    $item->route('shopper.custom.index');
                    $item->setIcon('heroicon-o-star');
                });
            })
        );
    });
}
</code-snippet>

### Override Existing Livewire Components

Shopper components can be overridden via config files in `config/shopper/components/`. Available config files:

- `account.php` - Account/profile components
- `brand.php` - Brand management
- `category.php` - Category management
- `collection.php` - Collection management
- `customer.php` - Customer management
- `dashboard.php` - Dashboard components
- `discount.php` - Discount management
- `order.php` - Order management
- `product.php` - Product management (pages, forms, modals, slide-overs)
- `review.php` - Review management
- `setting.php` - Settings pages and components

Each config file has two sections: `pages` (full page components) and `components` (partial components like forms, modals, slide-overs).

<code-snippet name="Override existing component" lang="php">
// Publish the config file first
// php artisan vendor:publish --tag=shopper-config

// config/shopper/components/product.php
return [
    'pages' => [
        'product-index' => App\Livewire\Shopper\Products\Index::class, // Override index page
        'product-edit' => \Shopper\Livewire\Pages\Product\Edit::class, // Keep default
        'variant-edit' => \Shopper\Livewire\Pages\Product\Variant::class,
        'attribute-index' => \Shopper\Livewire\Pages\Attribute\Browse::class,
    ],

    'components' => [
        'products.form.edit' => App\Livewire\Shopper\Products\EditForm::class, // Override form
        'products.form.media' => \Shopper\Livewire\Components\Products\Form\Media::class,
        // ... keep other defaults
    ],
];
</code-snippet>

<code-snippet name="Create custom component extending base" lang="php">
// app/Livewire/Shopper/Products/Index.php
namespace App\Livewire\Shopper\Products;

use Filament\Tables\Table;
use Shopper\Livewire\Pages\Product\Index as BaseIndex;

class Index extends BaseIndex
{
    public function table(Table $table): Table
    {
        return parent::table($table)
            ->columns([
                // Add or modify columns
                ...parent::table($table)->getColumns(),
                TextColumn::make('custom_field'),
            ])
            ->filters([
                // Add custom filters
            ]);
    }
}
</code-snippet>

### Permissions

Shopper uses Spatie Laravel Permission. Check permissions in Livewire components:

<code-snippet name="Authorization in components" lang="php">
// In Livewire component
public function mount(): void
{
    $this->authorize('browse_products');
}

// In Blade
@can('add_products')
    <x-filament::button>Add Product</x-filament::button>
@endcan
</code-snippet>

### Helper Functions

- `shopper_table('products')` - Returns prefixed table name (e.g., `sh_products`)
- `generate_number()` - Generates order number with configured prefix
- `shopper_fallback_url()` - Returns fallback image URL
- `shopper_setting('shop_name')` - Gets shop setting value
- `shopper()->auth()->user()` - Gets authenticated admin user

### Feature Flags

Enable/disable features in `config/shopper/features.php`:

<code-snippet name="Check feature flag" lang="php">
if (\Shopper\Feature::enabled('review')) {
    // Show reviews functionality
}
</code-snippet>

### Artisan Commands

- `php artisan shopper:install` - Install Shopper
- `php artisan shopper:user` - Create admin user
- `php artisan shopper:publish` - Publish assets and config
- `php artisan shopper:link` - Create storage symlink
- `php artisan make:shopper-page {PageName}` - Create custom admin page
- `php artisan shopper:component:publish` - Publish specific components
- `php artisan shopper:starter-kit:install` - Install frontend starter kit

### Media Management

Products use Spatie Media Library. Collections are configured in `config/shopper/media.php`:

<code-snippet name="Add media to product" lang="php">
// Add thumbnail
$product->addMedia($file)
    ->toMediaCollection(config('shopper.media.storage.thumbnail_collection'));

// Add gallery images
$product->addMedia($file)
    ->toMediaCollection(config('shopper.media.storage.collection_name'));

// Get URLs
$thumbnail = $product->getFirstMediaUrl(config('shopper.media.storage.thumbnail_collection'));
</code-snippet>

### Shopper Blade Components

Use these Shopper Blade components in your custom pages:

- `<x-shopper::container>` - Main content container
- `<x-shopper::card>` - Card wrapper
- `<x-shopper::heading :title="$title">` - Page heading with optional action slot
- `<x-shopper::breadcrumb>` - Breadcrumb navigation
- `<x-filament::button>` - Primary button
- `<x-filament::button color="gray">` - Gray/default button
- `<x-shopper::empty-card>` - Empty state card
- `<x-shopper::separator>` - Section separator

### Database Tables

All Shopper tables use a configurable prefix (default: `sh_`). Main tables:

- `sh_products`, `sh_product_variants` - Products and variants
- `sh_orders`, `sh_order_items` - Orders and line items
- `sh_categories`, `sh_brands`, `sh_collections` - Catalog organization
- `sh_customers`, `sh_addresses` - Customer data
- `sh_inventories`, `sh_inventory_histories` - Stock management
- `sh_discounts` - Discount codes and rules

### Testing

When testing Shopper functionality, use factories and respect the model contracts:

<code-snippet name="Testing with Shopper models" lang="php">
use Shopper\Core\Models\Product;

it('can create a product', function () {
    $product = Product::factory()->create([
        'name' => 'Test Product',
        'is_visible' => true,
    ]);

    expect($product)->toBeInstanceOf(Product::class)
        ->and($product->is_visible)->toBeTrue();
});
</code-snippet>
</laravel-boost-guidelines>
