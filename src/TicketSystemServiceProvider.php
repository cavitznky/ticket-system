<?php

namespace Digitalcake\TicketSystem;

use Digitalcake\TicketSystem\Commands\TicketSystemCommand;
use Digitalcake\TicketSystem\Livewire\TicketSystem;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TicketSystemServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('ticket-system')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_ticket_system_table')
            ->hasCommand(TicketSystemCommand::class)
            ->hasTranslations();
    }

    public function bootingPackage()
    {
        // Save the Livewire component
        Livewire::component('ticket-system', TicketSystem::class);

        // Publish the migration files
        $this->publishes([
            __DIR__.'/../database/migrations/create_ticket_system_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_ticket_system_table.php'),
        ], 'ticket-system-migrations');

        // Publish the translation files
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/ticket-system'),
        ], 'ticket-system-translations');

        // Publish the views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/ticket-system'),
        ], 'ticket-system-views');

        // Publish the config file
        $this->publishes([
            __DIR__.'/../config/ticket-system.php' => config_path('ticket-system.php'),
        ], 'ticket-system-config');

        // Publish the Livewire components
        $this->publishes([
            __DIR__.'/Livewire/TicketSystem.php' => app_path('Livewire/TicketSystem.php'),
        ], 'ticket-system-components');

        // Publish the models
        $this->publishes([
            __DIR__.'/Models' => app_path('Models/TicketSystem'),
        ], 'ticket-system-models');

        // Publish the traits
        $this->publishes([
            __DIR__.'/Traits' => app_path('Traits/TicketSystem'),
        ], 'ticket-system-traits');

        // Publish all components together
        $this->publishes([
            __DIR__.'/Livewire/TicketSystem.php' => app_path('Livewire/TicketSystem.php'),
            __DIR__.'/Models' => app_path('Models/TicketSystem'),
            __DIR__.'/Traits' => app_path('Traits/TicketSystem'),
        ], 'ticket-system-all-components');
    }
}
