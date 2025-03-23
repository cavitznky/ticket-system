<?php

namespace Digitalcake\TicketSystem\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Digitalcake\TicketSystem\Models\Ticket;
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
    public $currentTicket = null;
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
            'isAdmin' => $this->isAdmin()
        ]);
    }
    
    /**
     * Kullanıcının admin olup olmadığını kontrol eder
     */
    protected function isAdmin(): bool
    {
        $user = Auth::user();
        return $user && method_exists($user, 'isTicketAdmin') && $user->isTicketAdmin();
    }
    
    /**
     * Arama değiştiğinde ilk sayfaya dön
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }
    
    /**
     * Durum filtresi değiştiğinde ilk sayfaya dön
     */
    public function updatedStatus(): void
    {
        $this->resetPage();
    }
    
    /**
     * Öncelik filtresi değiştiğinde ilk sayfaya dön
     */
    public function updatedPriority(): void
    {
        $this->resetPage();
    }
    
    /**
     * Yanıt modalı kapatıldığında ticket referansını temizle
     */
    public function updatedShowResponseModal($value): void
    {
        if (!$value) {
            $this->reset(['currentTicket', 'responseContent']);
        }
    }
    
    /**
     * Düzenleme modalı kapatıldığında ticket referansını temizle
     */
    public function updatedShowEditModal($value): void
    {
        if (!$value) {
            $this->reset(['currentTicket']);
        }
    }
    
    protected function getTickets(): LengthAwarePaginator
    {
        $query = Ticket::query()->with('ticketable');
        
        // Admin olmayan kullanıcılar sadece kendi ticketlarını görebilir
        if (!$this->isAdmin()) {
            $user = Auth::user();
            $query->where('ticketable_type', get_class($user))
                  ->where('ticketable_id', $user->id);
        }
        
        // Status filtreleme
        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }
        
        // Priority filtreleme
        if (!empty($this->priority)) {
            $query->where('priority', $this->priority);
        }
        
        // Arama filtreleme - En son uygulayalım ki diğer filtrelerden etkilenmesin
        if (!empty($this->search)) {
            $search = '%' . $this->search . '%';
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', $search)
                  ->orWhere('description', 'like', $search);
            });
        }
        
        return $query->latest()->paginate(config('ticket-system.per_page', 10));
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
        session()->flash('message', __('ticket-system::ticket-system.messages.created'));
    }
    
    // Ticket düzenleme işlemleri
    public function openEditModal(Ticket $ticket): void
    {
        // Admin olmayan kullanıcılar sadece kendi ticketlarını düzenleyebilir
        if (!$this->isAdmin() && !$this->isOwner($ticket)) {
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
     * Ticketın sahibi olup olmadığını kontrol eder
     */
    protected function isOwner(Ticket $ticket): bool
    {
        $user = Auth::user();
        return $ticket->ticketable_type === get_class($user) && 
               $ticket->ticketable_id === $user->id;
    }
    
    public function updateTicket(): void
    {
        // Admin olmayan kullanıcılar sadece kendi ticketlarını düzenleyebilir
        if (!$this->isAdmin() && !$this->isOwner($this->currentTicket)) {
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
    
    // Ticket yanıtlama işlemleri
    public function openResponseModal($ticketId): void
    {
        $this->resetValidation();
        $this->reset(['currentTicket', 'responseContent']);

        // Ticket ID ile ticketı bulup ilişkileri ile birlikte yükle
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
        
        // Yanıt verildiğinde otomatik olarak ticket durumunu "in_progress" olarak güncelleme
        if ($this->currentTicket->isOpen()) {
            $this->currentTicket->markAsInProgress();
        }
        
        $this->closeResponseModal();
        session()->flash('message', __('ticket-system::ticket-system.messages.responded'));
    }
    
    // Ticket durumu değiştirme
    public function changeStatus(Ticket $ticket, string $status): void
    {
        // Admin olmayan kullanıcılar sadece kendi ticketlarının durumunu değiştirebilir
        if (!$this->isAdmin() && !$this->isOwner($ticket)) {
            session()->flash('error', __('ticket-system::ticket-system.messages.no_status_permission'));
            return;
        }
        
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
        session()->flash('message', __('ticket-system::ticket-system.messages.status_changed'));
    }
    
    public function resetFilters(): void
    {
        $this->reset(['search', 'status', 'priority']);
    }

    /**
     * Yanıtlama modalını kapat ve ilgili değişkenleri temizle
     */
    public function closeResponseModal(): void
    {
        $this->reset(['currentTicket', 'responseContent']);
        $this->showResponseModal = false;
    }

    /**
     * Ticket silme işlemi
     */
    public function deleteTicket(Ticket $ticket): void 
    {
        // Silme yetkisi yoksa işlemi reddet
        if (!$this->isAdmin()) {
            session()->flash('error', __('ticket-system::ticket-system.messages.no_delete_permission'));
            return;
        }

        // Ticket'ı ve ilişkili yanıtları sil
        $ticket->responses()->delete();
        $ticket->delete();

        session()->flash('message', __('ticket-system::ticket-system.messages.deleted'));
    }
} 