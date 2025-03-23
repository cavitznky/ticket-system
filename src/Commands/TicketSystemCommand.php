<?php

namespace Digitalcake\TicketSystem\Commands;

use Illuminate\Console\Command;

class TicketSystemCommand extends Command
{
    public $signature = 'ticket-system:install {--migrate : Doğrudan migrasyon çalıştır} {--M|publish-migrations : Migrasyon dosyalarını yayınlar}';

    public $description = 'Laravel Ticket Sistemi kurulumunu tamamlar';

    public function handle(): int
    {
        $this->comment('Ticket Sistemi kurulumu başlatılıyor...');

        // Migrasyon dosyalarını yayınlama
        if ($this->option('publish-migrations')) {
            $this->comment('Migrasyon dosyaları yayınlanıyor...');
            $this->call('vendor:publish', [
                '--tag' => 'ticket-system-migrations',
                '--force' => true,
            ]);
            $this->info('Migrasyon dosyaları başarıyla yayınlandı!');
        }

        // Migrasyon çalıştırma
        if ($this->option('migrate')) {
            $this->comment('Migrasyon dosyaları çalıştırılıyor...');
            $this->call('migrate');
            $this->info('Migrasyonlar başarıyla çalıştırıldı!');
        }

        // Config dosyalarını yayınlama
        $this->comment('Konfigürasyon dosyaları yayınlanıyor...');
        $this->call('vendor:publish', [
            '--tag' => 'ticket-system-config',
            '--force' => true,
        ]);

        $this->info('Ticket Sistemi başarıyla kuruldu!');
        $this->info('Aşağıdaki komutları kullanarak paket bileşenlerini özelleştirebilirsiniz:');
        $this->comment('php artisan vendor:publish --tag="ticket-system-views"');
        $this->comment('php artisan vendor:publish --tag="ticket-system-migrations"');

        return self::SUCCESS;
    }
}
