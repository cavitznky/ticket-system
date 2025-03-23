<?php

namespace Digitalcake\TicketSystem\Commands;

use Illuminate\Console\Command;

class TicketSystemCommand extends Command
{
    public $signature = 'ticket-system:install {--migrate : Doğrudan migrasyon çalıştır} {--M|publish-migrations : Migrasyon dosyalarını yayınlar}';

    public $description = 'Completes Laravel Ticket System setup';

    public function handle(): int
    {
        $this->comment('Ticket System installation started...');

        // Publish migrations
        if ($this->option('publish-migrations')) {
            $this->comment('Migrations are being published...');
            $this->call('vendor:publish', [
                '--tag' => 'ticket-system-migrations',
                '--force' => true,
            ]);
            $this->info('Migrations published successfully!');
        }

        // Run migrations
        if ($this->option('migrate')) {
            $this->comment('Migrations are being run...');
            $this->call('migrate');
            $this->info('Migrations run successfully!');
        }

        // Publish config files
        $this->comment('Config files are being published...');
        $this->call('vendor:publish', [
            '--tag' => 'ticket-system-config',
            '--force' => true,
        ]);

        $this->info('Ticket System installed successfully!');
        $this->info('You can customize the package components using the following commands:');
        $this->comment('php artisan vendor:publish --tag="ticket-system-views"');
        $this->comment('php artisan vendor:publish --tag="ticket-system-migrations"');

        return self::SUCCESS;
    }
}
