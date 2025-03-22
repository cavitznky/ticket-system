<?php

namespace Digitalcake\TicketSystem\Traits;

use Digitalcake\TicketSystem\Models\Ticket;
use Digitalcake\TicketSystem\Models\TicketResponse;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasTickets
{
    /**
     * Bu model tarafından oluşturulan ticket'lar
     */
    public function tickets(): MorphMany
    {
        return $this->morphMany(Ticket::class, 'ticketable');
    }

    /**
     * Bu model tarafından oluşturulan ticket yanıtları
     */
    public function ticketResponses(): MorphMany
    {
        return $this->morphMany(TicketResponse::class, 'respondable');
    }

    /**
     * Yeni bir ticket oluştur
     */
    public function createTicket(array $attributes): Ticket
    {
        return $this->tickets()->create($attributes);
    }

    /**
     * Bir ticket'a yanıt ver
     */
    public function respondToTicket(Ticket $ticket, string $content): TicketResponse
    {
        return $this->ticketResponses()->create([
            'ticket_id' => $ticket->id,
            'content' => $content,
        ]);
    }
} 