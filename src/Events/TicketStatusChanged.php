<?php

namespace Digitalcake\TicketSystem\Events;

use Digitalcake\TicketSystem\Models\Ticket;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The ticket instance.
     *
     * @var Ticket
     */
    public Ticket $ticket;

    /**
     * The old status.
     *
     * @var string
     */
    public string $oldStatus;

    /**
     * The new status.
     *
     * @var string
     */
    public string $newStatus;

    /**
     * Create a new event instance.
     *
     * @param  Ticket  $ticket
     * @param  string  $oldStatus
     * @param  string  $newStatus
     * @return void
     */
    public function __construct(Ticket $ticket, string $oldStatus, string $newStatus)
    {
        $this->ticket = $ticket;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }
} 