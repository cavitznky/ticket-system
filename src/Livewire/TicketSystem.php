<?php

namespace Digitalcake\TicketSystem\Livewire;

use Digitalcake\TicketSystem\Models\Ticket;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TicketSystem extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Search and filtering
    public string $search = '';

    public string $status = '';

    public string $priority = '';

    // Modal controllers
    public bool $showCreateModal = false;

    public bool $showEditModal = false;

    public bool $showResponseModal = false;

    // Form fields
    public $currentTicket = null;

    public string $title = '';

    public string $description = '';

    public string $selectedPriority = 'medium';

    public string $responseContent = '';

    // Events to listen
    protected $listeners = ['refreshTickets' => '$refresh'];

    protected function rules(): array
    {
        return [
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'selectedPriority' => 'required|in:low,medium,high,urgent',
            'responseContent' => 'required|min:3',
        ];
    }

    public function render()
    {
        return view('ticket-system::livewire.ticket-system', [
            'tickets' => $this->getTickets(),
            'isAdmin' => $this->isAdmin(),
        ]);
    }

    /**
     * Checks if the user is an admin
     */
    protected function isAdmin(): bool
    {
        $user = Auth::user();

        return $user && method_exists($user, 'getTicketAdmin') && $user->getTicketAdmin();
    }

    /**
     * Redirects to the first page when the search changes
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Redirects to the first page when the status changes
     */
    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    /**
     * Redirects to the first page when the priority changes
     */
    public function updatedPriority(): void
    {
        $this->resetPage();
    }

    /**
     * Cleans the ticket reference when the response modal is closed
     */
    public function updatedShowResponseModal($value): void
    {
        if (! $value) {
            $this->reset(['currentTicket', 'responseContent']);
        }
    }

    /**
     * Cleans the ticket reference when the edit modal is closed
     */
    public function updatedShowEditModal($value): void
    {
        if (! $value) {
            $this->reset(['currentTicket']);
        }
    }

    protected function getTickets(): LengthAwarePaginator
    {
        $query = Ticket::query()->with('ticketable');

        // Non-admin users can only see their own tickets
        if (! $this->isAdmin()) {
            $user = Auth::user();
            $query->where('ticketable_type', get_class($user))
                ->where('ticketable_id', $user->id);
        }

        // Status filtering
        if (! empty($this->status)) {
            $query->where('status', $this->status);
        }

        // Priority filtering
        if (! empty($this->priority)) {
            $query->where('priority', $this->priority);
        }

        // Search filtering - Apply last to avoid other filters affecting it
        if (! empty($this->search)) {
            $search = '%'.$this->search.'%';
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', $search)
                    ->orWhere('description', 'like', $search);
            });
        }

        return $query->latest()->paginate(config('ticket-system.per_page', 10));
    }

    // Ticket creation processes
    public function openCreateModal(): void
    {
        $this->resetValidation();
        $this->reset(['title', 'description', 'selectedPriority']);
        $this->showCreateModal = true;
    }

    public function createTicket(): void
    {
        $this->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'selectedPriority' => 'required|in:low,medium,high,urgent',
        ]);

        $user = Auth::user();
        $user->createTicket([
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->selectedPriority,
        ]);

        $this->showCreateModal = false;
        $this->reset(['title', 'description', 'selectedPriority']);
        session()->flash('message', __('ticket-system::ticket-system.messages.created'));
    }

    // Ticket editing processes
    public function openEditModal(Ticket $ticket): void
    {
        // Non-admin users can only edit their own tickets
        if (! $this->isAdmin() && ! $this->isOwner($ticket)) {
            session()->flash('error', __('ticket-system::ticket-system.messages.no_edit_permission'));

            return;
        }

        $this->resetValidation();
        $this->currentTicket = $ticket;
        $this->title = $ticket->title;
        $this->description = $ticket->description;
        $this->selectedPriority = $ticket->priority;
        $this->showEditModal = true;
    }

    /**
     * Checks if the ticket is owned by the user
     */
    protected function isOwner(Ticket $ticket): bool
    {
        $user = Auth::user();

        return $ticket->ticketable_type === get_class($user) &&
               $ticket->ticketable_id === $user->id;
    }

    public function updateTicket(): void
    {
        // Non-admin users can only edit their own tickets
        if (! $this->isAdmin() && ! $this->isOwner($this->currentTicket)) {
            session()->flash('error', __('ticket-system::ticket-system.messages.no_edit_permission'));

            return;
        }

        $this->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'selectedPriority' => 'required|in:low,medium,high,urgent',
        ]);

        $this->currentTicket->update([
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->selectedPriority,
        ]);

        $this->showEditModal = false;
        session()->flash('message', __('ticket-system::ticket-system.messages.updated'));
    }

    // Ticket response processes
    public function openResponseModal($ticketId): void
    {
        $this->resetValidation();
        $this->reset(['currentTicket', 'responseContent']);

        // Load the ticket with its responses and related models
        if (is_numeric($ticketId)) {
            $this->currentTicket = Ticket::with(['responses.respondable', 'ticketable'])
                ->findOrFail($ticketId);
            $this->showResponseModal = true;
        } else {
            session()->flash('error', __('ticket-system::ticket-system.messages.invalid_ticket'));
        }
    }

    public function submitResponse(): void
    {
        $this->validate([
            'responseContent' => 'required|min:3',
        ]);

        $user = Auth::user();
        $user->respondToTicket($this->currentTicket, $this->responseContent);

        // Automatically update the ticket status to "in_progress" when a response is submitted
        if ($this->currentTicket->isOpen()) {
            $this->currentTicket->markAsInProgress();
        }

        $this->closeResponseModal();
        session()->flash('message', __('ticket-system::ticket-system.messages.responded'));
    }

    // Ticket status change
    public function changeStatus(Ticket $ticket, string $status): void
    {
        // Non-admin users can only change the status of their own tickets
        if (! $this->isAdmin() && ! $this->isOwner($ticket)) {
            session()->flash('error', __('ticket-system::ticket-system.messages.no_status_permission'));

            return;
        }

        if (! in_array($status, ['open', 'in_progress', 'resolved', 'closed'])) {
            return;
        }

        $method = match ($status) {
            'open' => 'reopen',
            'in_progress' => 'markAsInProgress',
            'resolved' => 'markAsResolved',
            'closed' => 'markAsClosed',
        };

        $ticket->$method();
        session()->flash('message', __('ticket-system::ticket-system.messages.status_changed'));
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'status', 'priority']);
    }

    /**
     * Closes the response modal and clears the related variables
     */
    public function closeResponseModal(): void
    {
        $this->reset(['currentTicket', 'responseContent']);
        $this->showResponseModal = false;
    }

    /**
     * Ticket deletion process
     */
    public function deleteTicket(Ticket $ticket): void
    {
        // If the user does not have delete permission, reject the operation
        if (! $this->isAdmin()) {
            session()->flash('error', __('ticket-system::ticket-system.messages.no_delete_permission'));

            return;
        }

        // Delete the ticket and its related responses
        $ticket->responses()->delete();
        $ticket->delete();

        session()->flash('message', __('ticket-system::ticket-system.messages.deleted'));
    }
}
