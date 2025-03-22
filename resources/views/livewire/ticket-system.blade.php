<div>
    {{-- Mesaj bildirimleri --}}
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Ticket Sistemi</h4>
            <button class="btn btn-primary" wire:click="openCreateModal">
                <i class="fas fa-plus-circle mr-1"></i> Yeni Ticket
            </button>
        </div>

        <div class="card-body">
            {{-- Arama ve filtreleme --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Arama..." wire:model.debounce.300ms="search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <select class="form-control" wire:model="status">
                        <option value="">Durum: Tümü</option>
                        <option value="open">Açık</option>
                        <option value="in_progress">İşlemde</option>
                        <option value="resolved">Çözüldü</option>
                        <option value="closed">Kapalı</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select class="form-control" wire:model="priority">
                        <option value="">Öncelik: Tümü</option>
                        <option value="low">Düşük</option>
                        <option value="medium">Orta</option>
                        <option value="high">Yüksek</option>
                        <option value="urgent">Acil</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-outline-secondary btn-block" wire:click="resetFilters">
                        <i class="fas fa-undo mr-1"></i> Sıfırla
                    </button>
                </div>
            </div>

            {{-- Ticket tablosu --}}
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Başlık</th>
                            <th>Durum</th>
                            <th>Öncelik</th>
                            <th>Oluşturulma</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->id }}</td>
                                <td>{{ $ticket->title }}</td>
                                <td>
                                    <span class="badge 
                                        @if ($ticket->status == 'open') badge-secondary
                                        @elseif($ticket->status == 'in_progress') badge-primary
                                        @elseif($ticket->status == 'resolved') badge-success
                                        @elseif($ticket->status == 'closed') badge-dark @endif">
                                        @if ($ticket->status == 'open')
                                            Açık
                                        @elseif($ticket->status == 'in_progress')
                                            İşlemde
                                        @elseif($ticket->status == 'resolved')
                                            Çözüldü
                                        @elseif($ticket->status == 'closed')
                                            Kapalı
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span class="badge 
                                        @if ($ticket->priority == 'low') badge-info
                                        @elseif($ticket->priority == 'medium') badge-secondary
                                        @elseif($ticket->priority == 'high') badge-warning
                                        @elseif($ticket->priority == 'urgent') badge-danger @endif">
                                        @if ($ticket->priority == 'low')
                                            Düşük
                                        @elseif($ticket->priority == 'medium')
                                            Orta
                                        @elseif($ticket->priority == 'high')
                                            Yüksek
                                        @elseif($ticket->priority == 'urgent')
                                            Acil
                                        @endif
                                    </span>
                                </td>
                                <td>{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary" wire:click="openResponseModal({{ $ticket->id }})">
                                            <i class="fas fa-reply"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary" wire:click="openEditModal({{ $ticket->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-info dropdown-toggle" data-toggle="dropdown">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if (!$ticket->isOpen())
                                                    <a class="dropdown-item" href="#" wire:click.prevent="changeStatus({{ $ticket->id }}, 'open')">
                                                        <i class="fas fa-door-open text-secondary mr-1"></i> Tekrar Aç
                                                    </a>
                                                @endif
                                                @if (!$ticket->isInProgress())
                                                    <a class="dropdown-item" href="#" wire:click.prevent="changeStatus({{ $ticket->id }}, 'in_progress')">
                                                        <i class="fas fa-spinner text-primary mr-1"></i> İşleme Al
                                                    </a>
                                                @endif
                                                @if (!$ticket->isResolved())
                                                    <a class="dropdown-item" href="#" wire:click.prevent="changeStatus({{ $ticket->id }}, 'resolved')">
                                                        <i class="fas fa-check-circle text-success mr-1"></i> Çözüldü İşaretle
                                                    </a>
                                                @endif
                                                @if (!$ticket->isClosed())
                                                    <a class="dropdown-item" href="#" wire:click.prevent="changeStatus({{ $ticket->id }}, 'closed')">
                                                        <i class="fas fa-times-circle text-dark mr-1"></i> Kapat
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-ticket-alt display-4 d-block mb-2 text-muted"></i>
                                    <p class="lead">Henüz ticket bulunmuyor</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>

    {{-- Ticket Oluşturma Modal --}}
    <div class="modal @if ($showCreateModal) show d-block @endif" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yeni Ticket Oluştur</h5>
                    <button type="button" class="close" aria-label="Close" wire:click="$set('showCreateModal', false)">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="createTicket">
                        <div class="form-group">
                            <label for="title">Başlık</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" wire:model="title">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Açıklama</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="5" wire:model="description"></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="priority">Öncelik</label>
                            <select class="form-control @error('selectedPriority') is-invalid @enderror" id="priority" wire:model="selectedPriority">
                                <option value="low">Düşük</option>
                                <option value="medium">Orta</option>
                                <option value="high">Yüksek</option>
                                <option value="urgent">Acil</option>
                            </select>
                            @error('selectedPriority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary mr-2" wire:click="$set('showCreateModal', false)">İptal</button>
                            <button type="submit" class="btn btn-primary">Oluştur</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade @if ($showCreateModal) show @endif" wire:click="$set('showCreateModal', false)" @if (!$showCreateModal) style="display: none" @endif></div>

    {{-- Ticket Düzenleme Modal --}}
    <div class="modal @if ($showEditModal) show d-block @endif" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ticket Düzenle</h5>
                    <button type="button" class="close" aria-label="Close" wire:click="$set('showEditModal', false)">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateTicket">
                        <div class="form-group">
                            <label for="edit-title">Başlık</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="edit-title" wire:model="title">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="edit-description">Açıklama</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="edit-description" rows="5" wire:model="description"></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="edit-priority">Öncelik</label>
                            <select class="form-control @error('selectedPriority') is-invalid @enderror" id="edit-priority" wire:model="selectedPriority">
                                <option value="low">Düşük</option>
                                <option value="medium">Orta</option>
                                <option value="high">Yüksek</option>
                                <option value="urgent">Acil</option>
                            </select>
                            @error('selectedPriority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary mr-2" wire:click="$set('showEditModal', false)">İptal</button>
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade @if ($showEditModal) show @endif" wire:click="$set('showEditModal', false)" @if (!$showEditModal) style="display: none" @endif></div>

    {{-- Ticket Yanıtlama Modal --}}
    <div class="modal @if ($showResponseModal) show d-block @endif" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ticket Yanıtla</h5>
                    <button type="button" class="close" aria-label="Close" wire:click="$set('showResponseModal', false)">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($ticket)
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="mb-0">{{ $ticket->title }}</h5>
                                <span class="badge 
                                    @if ($ticket->status == 'open') badge-secondary
                                    @elseif($ticket->status == 'in_progress') badge-primary
                                    @elseif($ticket->status == 'resolved') badge-success
                                    @elseif($ticket->status == 'closed') badge-dark @endif">
                                    @if ($ticket->status == 'open')
                                        Açık
                                    @elseif($ticket->status == 'in_progress')
                                        İşlemde
                                    @elseif($ticket->status == 'resolved')
                                        Çözüldü
                                    @elseif($ticket->status == 'closed')
                                        Kapalı
                                    @endif
                                </span>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $ticket->description }}</p>
                                <small class="text-muted">{{ $ticket->created_at->format('d.m.Y H:i') }}</small>
                            </div>
                        </div>

                        @if ($ticket->responses->count() > 0)
                            <div class="mb-4">
                                <h6 class="border-bottom pb-2 mb-3">Önceki Yanıtlar</h6>

                                @foreach ($ticket->responses as $response)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <p class="card-text">{{ $response->content }}</p>
                                            <div class="d-flex justify-content-between">
                                                <small class="text-muted">{{ $response->respondable->name ?? 'Sistem' }}</small>
                                                <small class="text-muted">{{ $response->created_at->format('d.m.Y H:i') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <form wire:submit.prevent="submitResponse">
                            <div class="form-group">
                                <label for="responseContent">Yanıtınız</label>
                                <textarea class="form-control @error('responseContent') is-invalid @enderror" id="responseContent" rows="4" wire:model="responseContent"></textarea>
                                @error('responseContent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary mr-2" wire:click="$set('showResponseModal', false)">İptal</button>
                                <button type="submit" class="btn btn-primary">Yanıtla</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade @if ($showResponseModal) show @endif" wire:click="$set('showResponseModal', false)" @if (!$showResponseModal) style="display: none" @endif></div>
</div>
