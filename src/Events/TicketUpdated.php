<?php

namespace Digitalcake\TicketSystem\Events;

use Digitalcake\TicketSystem\Models\Ticket;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The ticket instance.
     *
     * @var Ticket
     */
    public Ticket $ticket;

    /**
     * The original ticket data before the update.
     *
     * @var array
     */
    public array $originalData;

    /**
     * Create a new event instance.
     *
     * @param  Ticket  $ticket
     * @param  array  $originalData
     * @return void
     */
    public function __construct(Ticket $ticket, array $originalData)
    {
        $this->ticket = $ticket;
        $this->originalData = $originalData;
    }
} 