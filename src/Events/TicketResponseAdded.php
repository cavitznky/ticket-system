<?php

namespace Digitalcake\TicketSystem\Events;

use Digitalcake\TicketSystem\Models\Ticket;
use Digitalcake\TicketSystem\Models\TicketResponse;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketResponseAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The ticket instance.
     *
     * @var Ticket
     */
    public Ticket $ticket;

    /**
     * The ticket response instance.
     *
     * @var TicketResponse
     */
    public TicketResponse $response;

    /**
     * Create a new event instance.
     *
     * @param  Ticket  $ticket
     * @param  TicketResponse  $response
     * @return void
     */
    public function __construct(Ticket $ticket, TicketResponse $response)
    {
        $this->ticket = $ticket;
        $this->response = $response;
    }
} 