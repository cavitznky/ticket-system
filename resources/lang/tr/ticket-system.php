<?php

return [
    'title' => 'Destek Talepleri',
    'admin_badge' => 'Admin',
    'new_ticket' => 'Yeni Destek Talebi',
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
    'no_tickets' => 'Henüz destek talebi bulunmuyor',
    'modal' => [
        'create' => [
            'title' => 'Yeni Destek Talebi Oluştur',
            'form' => [
                'title' => 'Başlık',
                'description' => 'Açıklama',
                'priority' => 'Öncelik',
                'placeholder' => [
                    'title' => 'Destek talebi başlığını girin...',
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
            'title' => 'Destek Talebini Düzenle',
            'buttons' => [
                'cancel' => 'İptal',
                'update' => 'Güncelle',
            ],
        ],
        'response' => [
            'title' => 'Destek Talebini Yanıtla',
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
        'delete' => 'Destek Talebi Sil',
    ],
    'messages' => [
        'created' => 'Destek talebi başarıyla oluşturuldu.',
        'updated' => 'Destek talebi başarıyla güncellendi.',
        'responded' => 'Yanıtınız başarıyla kaydedildi.',
        'status_changed' => 'Destek talebi durumu güncellendi.',
        'deleted' => 'Destek talebi başarıyla silindi.',
        'no_permission' => 'Bu işlemi gerçekleştirmek için yetkiniz yok.',
        'no_edit_permission' => 'Bu destek talebini düzenleme yetkiniz yok.',
        'no_status_permission' => 'Bu destek talebinin durumunu değiştirme yetkiniz yok.',
        'no_delete_permission' => 'Bu destek talebini silme yetkiniz yok.',
        'invalid_ticket' => 'Geçersiz destek talebi ID.',
    ],
    'unknown' => 'Bilinmiyor',
    'confirm_delete' => 'Bu destek talebini silmek istediğinize emin misiniz? Bu işlem geri alınamaz.',
];
