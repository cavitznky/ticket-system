<?php

namespace Digitalcake\TicketSystem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'ticketable_id',
        'ticketable_type',
    ];

    protected $casts = [
        'status' => 'string',
        'priority' => 'string',
    ];

    // Ticket'ı oluşturan kullanıcıya polimorfik bağlantı
    public function ticketable(): MorphTo
    {
        return $this->morphTo();
    }

    // Ticket cevapları
    public function responses(): HasMany
    {
        return $this->hasMany(TicketResponse::class);
    }

    // Helper methods
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function isResolved(): bool
    {
        return $this->status === 'resolved';
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    // Custom methods to update status
    public function markAsInProgress(): void
    {
        $this->update(['status' => 'in_progress']);
    }

    public function markAsResolved(): void
    {
        $this->update(['status' => 'resolved']);
    }

    public function markAsClosed(): void
    {
        $this->update(['status' => 'closed']);
    }
    
    public function reopen(): void
    {
        $this->update(['status' => 'open']);
    }
} 