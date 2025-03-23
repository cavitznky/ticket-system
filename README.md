# Laravel Ticket System

A comprehensive ticket system for Laravel applications.

## Installation

You can install the package via composer:

```bash
composer require cavitznky/ticket-system
```

## Publishing Assets

You can publish the config, migrations, views, and translations using the following commands:

```bash
# Publish migrations
php artisan vendor:publish --tag="ticket-system-migrations"

# Publish config
php artisan vendor:publish --tag="ticket-system-config"

# Publish views
php artisan vendor:publish --tag="ticket-system-views"

# Publish translations
php artisan vendor:publish --tag="ticket-system-translations"

# Publish Livewire component
php artisan vendor:publish --tag="ticket-system-components"

# Publish models
php artisan vendor:publish --tag="ticket-system-models"

# Publish traits
php artisan vendor:publish --tag="ticket-system-traits"

# Publish all components (Livewire, Models, Traits)
php artisan vendor:publish --tag="ticket-system-all-components"

# Or publish everything
php artisan vendor:publish --provider="Digitalcake\TicketSystem\TicketSystemServiceProvider"
```

## Customization

### Customizing the components

You can publish and modify all the components to adapt them to your needs:

1. Publish the components you want to customize:
```bash
# For example, to customize the Livewire component
php artisan vendor:publish --tag="ticket-system-components"
```

2. After publishing, the components will be available in your application:
   - Livewire component: `app/Livewire/TicketSystem.php`
   - Models: `app/Models/TicketSystem/`
   - Traits: `app/Traits/TicketSystem/`

3. Modify them according to your needs. When you publish a component, you take full control of it and it will no longer be updated when you update the package.

### Using published components

If you've published the Livewire component, make sure to update your view to use your application's namespace:

```blade
<livewire:ticket-system /> <!-- Uses the package component -->

<!-- After publishing the Livewire component: -->
<livewire:ticket-system /> <!-- Now uses your customized component in App\Livewire -->
```

Note: Laravel will automatically use the component from your application instead of the one from the package.

## Usage

To make your User model compatible with the ticket system, use the `HasTickets` trait:

```php
use Digitalcake\TicketSystem\Traits\HasTickets;

class User extends Authenticatable
{
    use HasTickets;
    
    // ...
}
```

To define admin users who can manage all tickets, add the `getTicketAdmin` method to your User model:

```php
public function getTicketAdmin(): bool
{
    // Define your logic to determine if a user is an admin
    return $this->isAdmin(); // or any other logic
}
```

### Adding the Livewire Component

Add the ticket system component to your view:

```blade
<livewire:ticket-system />
```

## Features

- Create, view, edit and delete tickets
- Respond to tickets
- Change ticket status (open, in progress, resolved, closed)
- Set ticket priority (low, medium, high, urgent)
- Filter tickets by status and priority
- Search tickets by title and description
- Multi-language support (EN, FR, NL, TR)

## Languages

The package supports the following languages:
- English (en)
- French (fr)
- Dutch (nl)
- Turkish (tr)

## Configuration

You can customize the ticket system by publishing the config file:

```php
return [
    // Number of tickets per page
    'per_page' => 10,
    
    // Other configuration options...
];
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
