<?php

return [
    'title' => 'Destek Talepleri',
    'admin_badge' => 'Admin',
    'new_ticket' => 'Yeni Ticket',
    'status' => [
        'all' => 'Durum: Tümü',
        'open' => 'Açık',
        'in_progress' => 'İşlemde',
        'resolved' => 'Çözüldü',
        'closed' => 'Kapalı',
    ],
    'priority' => [
        'all' => 'Öncelik: Tümü',
        'low' => 'Düşük',
        'medium' => 'Orta',
        'high' => 'Yüksek',
        'urgent' => 'Acil',
        'low_full' => 'Düşük Öncelik',
        'medium_full' => 'Orta Öncelik',
        'high_full' => 'Yüksek Öncelik',
        'urgent_full' => 'Acil Öncelik',
    ],
    'search' => 'Arama...',
    'reset' => 'Sıfırla',
    'columns' => [
        'title' => 'Başlık',
        'creator' => 'Oluşturan',
        'status' => 'Durum',
        'priority' => 'Öncelik',
        'created_at' => 'Oluşturulma',
        'actions' => 'İşlemler',
    ],
    'no_tickets' => 'Henüz ticket bulunmuyor',
    'modal' => [
        'create' => [
            'title' => 'Yeni Ticket Oluştur',
            'form' => [
                'title' => 'Başlık',
                'description' => 'Açıklama',
                'priority' => 'Öncelik',
                'placeholder' => [
                    'title' => 'Ticket başlığını girin...',
                    'description' => 'Sorununuzu detaylı olarak açıklayın...',
                ],
                'validation' => [
                    'title_required' => 'Başlık alanı gereklidir.',
                    'description_required' => 'Açıklama alanı gereklidir.',
                    'priority_required' => 'Öncelik alanı gereklidir.',
                ],
            ],
            'buttons' => [
                'cancel' => 'İptal',
                'create' => 'Oluştur',
            ],
        ],
        'edit' => [
            'title' => 'Ticket Düzenle',
            'buttons' => [
                'cancel' => 'İptal',
                'update' => 'Güncelle',
            ],
        ],
        'response' => [
            'title' => 'Ticket Yanıtla',
            'responses_title' => 'Yanıtlar',
            'form' => [
                'placeholder' => 'Yanıtınızı buraya yazın...',
                'validation' => [
                    'content_required' => 'Bu alan gereklidir.',
                ],
            ],
            'buttons' => [
                'cancel' => 'İptal',
                'respond' => 'Yanıtla',
            ],
        ],
    ],
    'actions' => [
        'reopen' => 'Tekrar Aç',
        'mark_in_progress' => 'İşleme Al',
        'mark_resolved' => 'Çözüldü İşaretle',
        'close' => 'Kapat',
        'delete' => 'Ticket Sil',
    ],
    'messages' => [
        'created' => 'Ticket başarıyla oluşturuldu.',
        'updated' => 'Ticket başarıyla güncellendi.',
        'responded' => 'Yanıtınız başarıyla kaydedildi.',
        'status_changed' => 'Ticket durumu güncellendi.',
        'deleted' => 'Ticket başarıyla silindi.',
        'no_permission' => 'Bu işlemi gerçekleştirmek için yetkiniz yok.',
        'no_edit_permission' => 'Bu ticketı düzenleme yetkiniz yok.',
        'no_status_permission' => 'Bu ticketın durumunu değiştirme yetkiniz yok.',
        'no_delete_permission' => 'Bu ticketı silme yetkiniz yok.',
        'invalid_ticket' => 'Geçersiz ticket ID.',
    ],
    'unknown' => 'Bilinmiyor',
]; 