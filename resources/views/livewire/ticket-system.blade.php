<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                @if ($isAdmin)
                    <small class="badge bg-primary me-2">{{ __('ticket-system::ticket-system.admin_badge') }}</small>
                @endif
                {{ __('ticket-system::ticket-system.title') }}
            </h4>
            <button class="btn btn-primary" wire:click="openCreateModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
                {{ __('ticket-system::ticket-system.new_ticket') }}
            </button>
        </div>

        <div class="card-body">
            {{-- Search and filtering --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="{{ __('ticket-system::ticket-system.search') }}" wire:model.live.debounce.500ms="search">
                    </div>
                </div>

                <div class="col-md-3">
                    <select class="form-control" wire:model.live="status">
                        <option value="">{{ __('ticket-system::ticket-system.status.all') }}</option>
                        <option value="open">{{ __('ticket-system::ticket-system.status.open') }}</option>
                        <option value="in_progress">{{ __('ticket-system::ticket-system.status.in_progress') }}</option>
                        <option value="resolved">{{ __('ticket-system::ticket-system.status.resolved') }}</option>
                        <option value="closed">{{ __('ticket-system::ticket-system.status.closed') }}</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select class="form-control" wire:model.live="priority">
                        <option value="">{{ __('ticket-system::ticket-system.priority.all') }}</option>
                        <option value="low">{{ __('ticket-system::ticket-system.priority.low') }}</option>
                        <option value="medium">{{ __('ticket-system::ticket-system.priority.medium') }}</option>
                        <option value="high">{{ __('ticket-system::ticket-system.priority.high') }}</option>
                        <option value="urgent">{{ __('ticket-system::ticket-system.priority.urgent') }}</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-outline-secondary btn-block w-100" wire:click="resetFilters">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <path d="M3 12a9 9 0 1 0 18 0 9 9 0 0 0-18 0z"></path>
                            <path d="M17 12H3"></path>
                            <path d="M12 17l-5-5 5-5"></path>
                        </svg>
                        {{ __('ticket-system::ticket-system.reset') }}
                    </button>
                </div>
            </div>

            {{-- Ticket table --}}
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('ticket-system::ticket-system.columns.title') }}</th>
                            <th>{{ __('ticket-system::ticket-system.columns.creator') }}</th>
                            <th>{{ __('ticket-system::ticket-system.columns.status') }}</th>
                            <th>{{ __('ticket-system::ticket-system.columns.priority') }}</th>
                            <th>{{ __('ticket-system::ticket-system.columns.created_at') }}</th>
                            <th class="text-end text-r">{{ __('ticket-system::ticket-system.columns.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr wire:key="ticket-{{ $ticket->id }}">
                                <td>{{ $ticket->title }}</td>
                                <td>{{ $ticket->ticketable->name ?? __('ticket-system::ticket-system.unknown') }}</td>
                                <td>
                                    <span class="badge 
                                        @if ($ticket->status == 'open') bg-secondary
                                        @elseif($ticket->status == 'in_progress') bg-primary
                                        @elseif($ticket->status == 'resolved') bg-success
                                        @elseif($ticket->status == 'closed') bg-dark @endif">
                                        @if ($ticket->status == 'open')
                                            {{ __('ticket-system::ticket-system.status.open') }}
                                        @elseif($ticket->status == 'in_progress')
                                            {{ __('ticket-system::ticket-system.status.in_progress') }}
                                        @elseif($ticket->status == 'resolved')
                                            {{ __('ticket-system::ticket-system.status.resolved') }}
                                        @elseif($ticket->status == 'closed')
                                            {{ __('ticket-system::ticket-system.status.closed') }}
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span class="badge 
                                        @if ($ticket->priority == 'low') bg-info
                                        @elseif($ticket->priority == 'medium') bg-secondary
                                        @elseif($ticket->priority == 'high') bg-warning
                                        @elseif($ticket->priority == 'urgent') bg-danger @endif">
                                        @if ($ticket->priority == 'low')
                                            {{ __('ticket-system::ticket-system.priority.low') }}
                                        @elseif($ticket->priority == 'medium')
                                            {{ __('ticket-system::ticket-system.priority.medium') }}
                                        @elseif($ticket->priority == 'high')
                                            {{ __('ticket-system::ticket-system.priority.high') }}
                                        @elseif($ticket->priority == 'urgent')
                                            {{ __('ticket-system::ticket-system.priority.urgent') }}
                                        @endif
                                    </span>
                                </td>
                                <td>{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                                <td class="text-end text-right">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary" wire:click="openResponseModal({{ $ticket->id }})" wire:key="response-btn-{{ $ticket->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 10h10a8 8 0 0 1 8 8v2M3 10l6 6m-6-6l6-6"></path>
                                            </svg>
                                        </button>
                                        @if ($isAdmin)
                                            <button class="btn btn-outline-secondary" wire:click="openEditModal({{ $ticket->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M12 20h9"></path>
                                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                                </svg>
                                            </button>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <circle cx="12" cy="12" r="1"></circle>
                                                        <circle cx="12" cy="5" r="1"></circle>
                                                        <circle cx="12" cy="19" r="1"></circle>
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if (!$ticket->isOpen())
                                                        <li>
                                                            <a class="dropdown-item" href="#" wire:click.prevent="changeStatus({{ $ticket->id }}, 'open')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-secondary me-1">
                                                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                                    <line x1="3" y1="9" x2="21" y2="9"></line>
                                                                    <line x1="9" y1="21" x2="9" y2="9"></line>
                                                                </svg>
                                                                {{ __('ticket-system::ticket-system.actions.reopen') }}
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (!$ticket->isInProgress())
                                                        <li>
                                                            <a class="dropdown-item" href="#" wire:click.prevent="changeStatus({{ $ticket->id }}, 'in_progress')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary me-1">
                                                                    <circle cx="12" cy="12" r="10"></circle>
                                                                    <polyline points="12 6 12 12 16 14"></polyline>
                                                                </svg>
                                                                {{ __('ticket-system::ticket-system.actions.mark_in_progress') }}
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (!$ticket->isResolved())
                                                        <li>
                                                            <a class="dropdown-item" href="#" wire:click.prevent="changeStatus({{ $ticket->id }}, 'resolved')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-success me-1">
                                                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                                </svg>
                                                                {{ __('ticket-system::ticket-system.actions.mark_resolved') }}
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (!$ticket->isClosed())
                                                        <li>
                                                            <a class="dropdown-item" href="#" wire:click.prevent="changeStatus({{ $ticket->id }}, 'closed')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-dark me-1">
                                                                    <circle cx="12" cy="12" r="10"></circle>
                                                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                                                </svg>
                                                                {{ __('ticket-system::ticket-system.actions.close') }}
                                                            </a>
                                                        </li>
                                                    @endif

                                                    @if ($isAdmin)
                                                        <li class="d-none">
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li class="d-none">
                                                            <a class="dropdown-item text-danger" href="#" wire:click.prevent="deleteTicket({{ $ticket->id }})" onclick="return confirm('{{ __('ticket-system::ticket-system.confirm_delete') }}')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-danger me-1">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                                </svg>
                                                                {{ __('ticket-system::ticket-system.actions.delete') }}
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-block mb-2 text-muted mx-auto">
                                        <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                        <path d="M7 15h0M2 9.5h20"></path>
                                    </svg>
                                    <p class="lead">{{ __('ticket-system::ticket-system.no_tickets') }}</p>
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

    {{-- Ticket Creation Modal --}}
    <div class="modal @if ($showCreateModal) show d-block @endif" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                        {{ __('ticket-system::ticket-system.modal.create.title') }}
                    </h5>
                    <button type="button" class="btn-close" aria-label="Close" wire:click="$set('showCreateModal', false)">
                        <span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="createTicket">
                        <div class="form-group mb-3">
                            <label class="text-muted mb-1" for="title">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                                {{ __('ticket-system::ticket-system.modal.create.form.title') }}
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" wire:model="title" placeholder="{{ __('ticket-system::ticket-system.modal.create.form.placeholder.title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ __('ticket-system::ticket-system.modal.create.form.validation.title_required') }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="text-muted mb-1" for="description">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                    <line x1="21" y1="10" x2="3" y2="10"></line>
                                    <line x1="21" y1="6" x2="3" y2="6"></line>
                                    <line x1="21" y1="14" x2="3" y2="14"></line>
                                    <line x1="21" y1="18" x2="3" y2="18"></line>
                                </svg>
                                {{ __('ticket-system::ticket-system.modal.create.form.description') }}
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="5" wire:model="description" placeholder="{{ __('ticket-system::ticket-system.modal.create.form.placeholder.description') }}"></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ __('ticket-system::ticket-system.modal.create.form.validation.description_required') }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="text-muted mb-1" for="priority">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                                </svg>
                                {{ __('ticket-system::ticket-system.modal.create.form.priority') }}
                            </label>
                            <select class="form-control @error('selectedPriority') is-invalid @enderror" id="priority" wire:model="selectedPriority">
                                <option value="low">{{ __('ticket-system::ticket-system.priority.low') }}</option>
                                <option value="medium">{{ __('ticket-system::ticket-system.priority.medium') }}</option>
                                <option value="high">{{ __('ticket-system::ticket-system.priority.high') }}</option>
                                <option value="urgent">{{ __('ticket-system::ticket-system.priority.urgent') }}</option>
                            </select>
                            @error('selectedPriority')
                                <div class="invalid-feedback">{{ __('ticket-system::ticket-system.modal.create.form.validation.priority_required') }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-secondary me-3" wire:click="$set('showCreateModal', false)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                                {{ __('ticket-system::ticket-system.modal.create.buttons.cancel') }}
                            </button>
                            <button type="submit" class="btn btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                    <polyline points="7 3 7 8 15 8"></polyline>
                                </svg>
                                {{ __('ticket-system::ticket-system.modal.create.buttons.create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade @if ($showCreateModal) show @endif" wire:click="$set('showCreateModal', false)" @if (!$showCreateModal) style="display: none" @endif></div>

    {{-- Ticket Edit Modal --}}
    <div class="modal @if ($showEditModal) show d-block @endif" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                        </svg>
                        {{ __('ticket-system::ticket-system.modal.edit.title') }}
                    </h5>
                    <button type="button" class="btn-close" aria-label="Close" wire:click="$set('showEditModal', false)">
                        <span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($currentTicket)
                        <form wire:submit.prevent="updateTicket">
                            <div class="form-group mb-3">
                                <label class="text-muted mb-1" for="edit-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                    {{ __('ticket-system::ticket-system.modal.create.form.title') }}
                                </label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="edit-title" wire:model="title">
                                @error('title')
                                    <div class="invalid-feedback">{{ __('ticket-system::ticket-system.modal.create.form.validation.title_required') }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="text-muted mb-1" for="edit-description">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                        <line x1="21" y1="10" x2="3" y2="10"></line>
                                        <line x1="21" y1="6" x2="3" y2="6"></line>
                                        <line x1="21" y1="14" x2="3" y2="14"></line>
                                        <line x1="21" y1="18" x2="3" y2="18"></line>
                                    </svg>
                                    {{ __('ticket-system::ticket-system.modal.create.form.description') }}
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="edit-description" rows="5" wire:model="description"></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ __('ticket-system::ticket-system.modal.create.form.validation.description_required') }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="text-muted mb-1" for="edit-priority">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                                    </svg>
                                    {{ __('ticket-system::ticket-system.modal.create.form.priority') }}
                                </label>
                                <select class="form-control @error('selectedPriority') is-invalid @enderror" id="edit-priority" wire:model="selectedPriority">
                                    <option value="low">{{ __('ticket-system::ticket-system.priority.low') }}</option>
                                    <option value="medium">{{ __('ticket-system::ticket-system.priority.medium') }}</option>
                                    <option value="high">{{ __('ticket-system::ticket-system.priority.high') }}</option>
                                    <option value="urgent">{{ __('ticket-system::ticket-system.priority.urgent') }}</option>
                                </select>
                                @error('selectedPriority')
                                    <div class="invalid-feedback">{{ __('ticket-system::ticket-system.modal.create.form.validation.priority_required') }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-secondary me-3" wire:click="$set('showEditModal', false)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                    {{ __('ticket-system::ticket-system.modal.edit.buttons.cancel') }}
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                        <polyline points="7 3 7 8 15 8"></polyline>
                                    </svg>
                                    {{ __('ticket-system::ticket-system.modal.edit.buttons.update') }}
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade @if ($showEditModal) show @endif" wire:click="$set('showEditModal', false)" @if (!$showEditModal) style="display: none" @endif></div>

    {{-- Ticket Response Modal --}}
    <div class="modal @if ($showResponseModal) show d-block @endif" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                            <path d="M3 10h10a8 8 0 0 1 8 8v2M3 10l6 6m-6-6l6-6"></path>
                        </svg>
                        {{ __('ticket-system::ticket-system.modal.response.title') }}
                    </h5>
                    <button type="button" class="btn-close" aria-label="Close" wire:click="closeResponseModal">
                        <span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($currentTicket)
                        {{-- Ticket title and details --}}
                        <div class="card border-left border-primary mb-4" style="border-left-width: 4px !important;">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                <h5 class="mb-0 font-weight-bold text-primary">{{ $currentTicket->title }}</h5>
                                <span class="badge 
                                    @if ($currentTicket->status == 'open') bg-secondary
                                    @elseif($currentTicket->status == 'in_progress') bg-primary
                                    @elseif($currentTicket->status == 'resolved') bg-success
                                    @elseif($currentTicket->status == 'closed') bg-dark @endif">
                                    @if ($currentTicket->status == 'open')
                                        {{ __('ticket-system::ticket-system.status.open') }}
                                    @elseif($currentTicket->status == 'in_progress')
                                        {{ __('ticket-system::ticket-system.status.in_progress') }}
                                    @elseif($currentTicket->status == 'resolved')
                                        {{ __('ticket-system::ticket-system.status.resolved') }}
                                    @elseif($currentTicket->status == 'closed')
                                        {{ __('ticket-system::ticket-system.status.closed') }}
                                    @endif
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="d-flex mb-3">

                                    <div>
                                        <h6 class="mb-1 font-weight-bold">{{ $currentTicket->ticketable->name ?? __('ticket-system::ticket-system.unknown') }}</h6>
                                        <small class="text-muted">{{ $currentTicket->created_at->format('d.m.Y H:i') }}</small>

                                        <div class="mt-2 p-3 bg-light rounded">
                                            {{ $currentTicket->description }}
                                        </div>

                                        <div class="mt-2">
                                            <span class="badge 
                                                @if ($currentTicket->priority == 'low') bg-info
                                                @elseif($currentTicket->priority == 'medium') bg-secondary
                                                @elseif($currentTicket->priority == 'high') bg-warning
                                                @elseif($currentTicket->priority == 'urgent') bg-danger @endif">
                                                @if ($currentTicket->priority == 'low')
                                                    {{ __('ticket-system::ticket-system.priority.low') }}
                                                @elseif($currentTicket->priority == 'medium')
                                                    {{ __('ticket-system::ticket-system.priority.medium') }}
                                                @elseif($currentTicket->priority == 'high')
                                                    {{ __('ticket-system::ticket-system.priority.high') }}
                                                @elseif($currentTicket->priority == 'urgent')
                                                    {{ __('ticket-system::ticket-system.priority.urgent') }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Previous responses --}}
                        @if ($currentTicket->responses->count() > 0)
                            <div class="mb-4">
                                <h6 class="mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                    {{ __('ticket-system::ticket-system.modal.response.responses_title') }} ({{ $currentTicket->responses->count() }})
                                </h6>

                                <div class="timeline">
                                    @foreach ($currentTicket->responses as $response)
                                        <div class="d-flex mb-3">
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0 font-weight-bold">{{ $response->respondable->name ?? 'Sistem' }}</h6>
                                                    <small class="text-muted">{{ $response->created_at->format('d.m.Y H:i') }}</small>
                                                </div>
                                                <div class="mt-2 p-3 bg-light rounded">
                                                    {!! nl2br(e($response->content)) !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Response form --}}
                        <div>
                            <form wire:submit.prevent="submitResponse">
                                <div class="form-group mb-3">
                                    <textarea class="form-control @error('responseContent') is-invalid @enderror" id="responseContent" rows="4" wire:model="responseContent" placeholder="{{ __('ticket-system::ticket-system.modal.response.form.placeholder') }}"></textarea>
                                    @error('responseContent')
                                        <div class="invalid-feedback">{{ __('ticket-system::ticket-system.modal.response.form.validation.content_required') }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary me-3" wire:click="closeResponseModal">{{ __('ticket-system::ticket-system.modal.response.buttons.cancel') }}</button>
                                    <button type="submit" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                            <line x1="22" y1="2" x2="11" y2="13"></line>
                                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                        </svg>
                                        {{ __('ticket-system::ticket-system.modal.response.buttons.respond') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade @if ($showResponseModal) show @endif" wire:click="closeResponseModal" @if (!$showResponseModal) style="display: none" @endif></div>
</div>
