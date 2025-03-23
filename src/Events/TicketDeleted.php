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
     *
     * @var int
     */
    public int $ticketId;

    /**
     * The ticket data before deletion.
     *
     * @var array
     */
    public array $ticketData;

    /**
     * Create a new event instance.
     *
     * @param  int  $ticketId
     * @param  array  $ticketData
     * @return void
     */
    public function __construct(int $ticketId, array $ticketData)
    {
        $this->ticketId = $ticketId;
        $this->ticketData = $ticketData;
    }
} 