<?php

namespace Digitalcake\TicketSystem;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Digitalcake\TicketSystem\Commands\TicketSystemCommand;
use Livewire\Livewire;
use Digitalcake\TicketSystem\Livewire\TicketSystem;

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
            ->hasCommand(TicketSystemCommand::class);
    }
    
    public function bootingPackage()
    {
        // Livewire komponentini kaydet
        Livewire::component('ticket-system', TicketSystem::class);

        // Migration dosyalarını publish edilebilir hale getir
        $this->publishes([
            __DIR__ . '/../database/migrations/create_ticket_system_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_ticket_system_table.php'),
        ], 'ticket-system-migrations');
    }
}
