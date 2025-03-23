<?php

namespace Digitalcake\TicketSystem\Traits;

use Digitalcake\TicketSystem\Models\Ticket;
use Digitalcake\TicketSystem\Models\TicketResponse;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasTickets
{
    /**
     * This model's tickets
     */
    public function tickets(): MorphMany
    {
        return $this->morphMany(Ticket::class, 'ticketable');
    }

    /**
     * This model's ticket responses
     */
    public function ticketResponses(): MorphMany
    {
        return $this->morphMany(TicketResponse::class, 'respondable');
    }

    /**
     * Create a new ticket
     */
    public function createTicket(array $attributes): Ticket
    {
        return $this->tickets()->create($attributes);
    }

    /**
     * Respond to a ticket
     */
    public function respondToTicket(Ticket $ticket, string $content): TicketResponse
    {
        return $this->ticketResponses()->create([
            'ticket_id' => $ticket->id,
            'content' => $content,
        ]);
    }
    
    /**
     * Checks if the user is an admin
     * 
     * The admin method specified in the config is called, or false if it is not defined
     */
    public function getTicketAdmin(): bool
    {
        $adminMethod = config('ticket-system.admin');
        
        // If the admin method is not defined, return false
        if ($adminMethod === null) {
            return false;
        }
        
        // If the method exists, call it
        if (method_exists($this, $adminMethod)) {
            return $this->{$adminMethod}();
        }
        
        return false;
    }
} 