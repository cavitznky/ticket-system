<?php

namespace Digitalcake\TicketSystem\Events;

use Digitalcake\TicketSystem\Models\Ticket;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The ticket instance.
     *
     * @var Ticket
     */
    public Ticket $ticket;
    
    /**
     * Create a new event instance.
     *
     * @param  Ticket  $ticket
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }
} 