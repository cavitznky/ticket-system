<?php

namespace Digitalcake\TicketSystem\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Digitalcake\TicketSystem\Models\Ticket;
use Digitalcake\TicketSystem\Models\TicketResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class TicketSystem extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    
    // Arama ve filtreleme
    public string $search = '';
    public string $status = '';
    public string $priority = '';
    
    // Modal kontrolleri
    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public bool $showResponseModal = false;
    
    // Form alanları
    public $ticket;
    public string $title = '';
    public string $description = '';
    public string $selectedPriority = 'medium';
    public string $responseContent = '';
    
    // Dinlenecek olaylar
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
        ]);
    }
    
    protected function getTickets(): LengthAwarePaginator
    {
        $query = Ticket::query()
            ->when($this->search, function ($q) {
                return $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($q) {
                return $q->where('status', $this->status);
            })
            ->when($this->priority, function ($q) {
                return $q->where('priority', $this->priority);
            })
            ->latest();
            
        return $query->paginate(10);
    }
    
    // Ticket oluşturma işlemleri
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
        session()->flash('message', 'Ticket başarıyla oluşturuldu.');
    }
    
    // Ticket düzenleme işlemleri
    public function openEditModal(Ticket $ticket): void
    {
        $this->resetValidation();
        $this->ticket = $ticket;
        $this->title = $ticket->title;
        $this->description = $ticket->description;
        $this->selectedPriority = $ticket->priority;
        $this->showEditModal = true;
    }
    
    public function updateTicket(): void
    {
        $this->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'selectedPriority' => 'required|in:low,medium,high,urgent',
        ]);
        
        $this->ticket->update([
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->selectedPriority,
        ]);
        
        $this->showEditModal = false;
        session()->flash('message', 'Ticket başarıyla güncellendi.');
    }
    
    // Ticket yanıtlama işlemleri
    public function openResponseModal(Ticket $ticket): void
    {
        $this->resetValidation();
        $this->ticket = $ticket;
        $this->responseContent = '';
        $this->showResponseModal = true;
    }
    
    public function submitResponse(): void
    {
        $this->validate([
            'responseContent' => 'required|min:3',
        ]);
        
        $user = Auth::user();
        $user->respondToTicket($this->ticket, $this->responseContent);
        
        // Yanıt verildiğinde otomatik olarak ticket durumunu "in_progress" olarak güncelleme
        if ($this->ticket->isOpen()) {
            $this->ticket->markAsInProgress();
        }
        
        $this->showResponseModal = false;
        $this->reset(['responseContent']);
        session()->flash('message', 'Yanıtınız başarıyla kaydedildi.');
    }
    
    // Ticket durumu değiştirme
    public function changeStatus(Ticket $ticket, string $status): void
    {
        if (!in_array($status, ['open', 'in_progress', 'resolved', 'closed'])) {
            return;
        }
        
        $method = match($status) {
            'open' => 'reopen',
            'in_progress' => 'markAsInProgress',
            'resolved' => 'markAsResolved',
            'closed' => 'markAsClosed',
        };
        
        $ticket->$method();
        session()->flash('message', 'Ticket durumu güncellendi.');
    }
    
    public function resetFilters(): void
    {
        $this->reset(['search', 'status', 'priority']);
    }
} 