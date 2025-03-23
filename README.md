# Laravel Ticket System

A comprehensive ticket system for Laravel applications.

## Installation

You can install the package via composer:

```bash
composer require digitalcake/ticket-system
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

# Or publish everything
php artisan vendor:publish --provider="Digitalcake\TicketSystem\TicketSystemServiceProvider"
```

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

To define admin users who can manage all tickets, add the `isTicketAdmin` method to your User model:

```php
public function isTicketAdmin(): bool
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
