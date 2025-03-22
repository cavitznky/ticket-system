# Laravel Ticket Sistemi

[![Latest Version on Packagist](https://img.shields.io/packagist/v/cavitznky/ticket-system.svg?style=flat-square)](https://packagist.org/packages/cavitznky/ticket-system)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/cavitznky/ticket-system/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/cavitznky/ticket-system/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/cavitznky/ticket-system/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/cavitznky/ticket-system/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/cavitznky/ticket-system.svg?style=flat-square)](https://packagist.org/packages/cavitznky/ticket-system)

Laravel uygulamaları için basit, kullanımı kolay bir ticket sistemi paketi. Bu paket, kullanıcıların ticket oluşturmasına, düzenlemesine ve yanıtlamasına olanak tanır.

## Özellikler

- Livewire ile oluşturulmuş, her Laravel projesine kolayca entegre edilebilir
- Polimorfik ilişkiler - herhangi bir model ile bağlantılı ticket'lar ve yanıtlar oluşturabilirsiniz
- Ticket durumu ve önceliği için filtreleme ve arama özelliği
- Yanıtlama ve durum güncelleme işlemleri
- Bootstrap 4 ile tasarlanmış kullanıcı dostu arayüz

## Kurulum

Paketi composer aracılığıyla kurun:

```bash
composer require cavitznky/ticket-system
```

İsteğe bağlı olarak, config dosyasını yayınlayabilirsiniz:

```bash
php artisan vendor:publish --tag="ticket-system-config"
```

Migrasyon dosyalarını çalıştırın:

```bash
php artisan migrate
```

## Kullanım

### Modelleri Yapılandırma

Ticket sisteminizi kullanmak istediğiniz model sınıflarında `HasTickets` trait'ini kullanın. Genellikle User modeli için:

```php
use Digitalcake\TicketSystem\Traits\HasTickets;

class User extends Authenticatable
{
    use HasTickets;
    
    // ...
}
```

### View'a Komponenti Ekleme

Livewire komponentini görünümünüze eklemek için:

```html
<livewire:ticket-system />
```

Ya da Blade bileşeni olarak:

```html
@livewire('ticket-system')
```

### Ticket Oluşturma

```php
$user = auth()->user();
$user->createTicket([
    'title' => 'Yardım talebi',
    'description' => 'Şu konuda yardıma ihtiyacım var...',
    'priority' => 'medium', // 'low', 'medium', 'high', 'urgent'
]);
```

### Ticket'a Yanıt Verme

```php
$user = auth()->user();
$ticket = \Digitalcake\TicketSystem\Models\Ticket::find(1);
$user->respondToTicket($ticket, 'İşte yanıtım...');
```

## Özelleştirme

Tasarımı özelleştirmek için görünüm dosyalarını yayınlayabilirsiniz:

```bash
php artisan vendor:publish --tag="ticket-system-views"
```

## Test

```bash
composer test
```

## Lisans

MIT lisansı altında dağıtılmaktadır. Daha fazla bilgi için [LICENSE.md](LICENSE.md) dosyasına bakın.
