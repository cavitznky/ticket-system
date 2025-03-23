<?php

namespace Digitalcake\TicketSystem\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The ticket ID.
     */
    public int $ticketId;

    /**
     * The ticket data before deletion.
     */
    public array $ticketData;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $ticketId, array $ticketData)
    {
        $this->ticketId = $ticketId;
        $this->ticketData = $ticketData;
    }
}
