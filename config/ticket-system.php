<?php

// config for Digitalcake/TicketSystem
return [
    /*
    |--------------------------------------------------------------------------
    | Ticket Sistemi Temel Ayarları
    |--------------------------------------------------------------------------
    |
    | Bu dosya, ticket sistemi için temel ayarları içerir.
    |
    */

    // Sayfalama başına düşen ticket sayısı
    'per_page' => 10,

    // Tarih formatı
    'date_format' => 'd.m.Y H:i',

    // Ticket durumları
    'statuses' => [
        'open' => 'Açık',
        'in_progress' => 'İşlemde',
        'resolved' => 'Çözüldü',
        'closed' => 'Kapalı',
    ],

    // Ticket öncelikleri
    'priorities' => [
        'low' => 'Düşük',
        'medium' => 'Orta',
        'high' => 'Yüksek',
        'urgent' => 'Acil',
    ],
];
