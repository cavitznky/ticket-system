<?php

namespace Digitalcake\TicketSystem\Commands;

use Illuminate\Console\Command;

class TicketSystemCommand extends Command
{
    public $signature = 'ticket-system:install';

    public $description = 'Laravel Ticket Sistemi kurulumunu tamamlar';

    public function handle(): int
    {
        $this->comment('Ticket Sistemi kurulumu başlatılıyor...');

        // Migrasyon çalıştırma
        $this->comment('Migrasyon dosyaları çalıştırılıyor...');
        $this->call('migrate');

        // Config dosyalarını yayınlama
        $this->comment('Konfigürasyon dosyaları yayınlanıyor...');
        $this->call('vendor:publish', [
            '--tag' => 'ticket-system-config',
            '--force' => true,
        ]);

        $this->info('Ticket Sistemi başarıyla kuruldu!');
        $this->info('Görünüm dosyalarını özelleştirmek isterseniz:');
        $this->comment('php artisan vendor:publish --tag="ticket-system-views"');

        return self::SUCCESS;
    }
}
