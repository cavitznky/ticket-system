<?php

namespace Digitalcake\TicketSystem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TicketResponse extends Model
{
    protected $fillable = [
        'content',
        'ticket_id',
        'respondable_id',
        'respondable_type',
    ];

    // Yanıtın bağlı olduğu ticket
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    // Yanıtı oluşturan kullanıcıya polimorfik bağlantı
    public function respondable(): MorphTo
    {
        return $this->morphTo();
    }
} 