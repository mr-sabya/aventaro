<div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-0 fw-bold">Currency Management</h5>
                <small class="text-muted">Manage global currencies and symbols</small>
            </div>
            <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#currencyModal" wire:click="resetFields">
                <i class="bi bi-plus-lg"></i> Add New Currency
            </button>
        </div>

        <div class="card-body">
            @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="row mb-3 g-3">
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted small border-0">Show</span>
                        <select wire:model.live="perPage" class="form-select border-0 bg-light">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-4">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" class="form-control border-start-0" placeholder="Search currency..." wire:model.live.debounce.300ms="search">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="cursor:pointer" wire:click="sortBy('id')" width="80">
                                ID <span class="ms-1 text-muted small">{{ $sortField === 'id' ? ($sortDirection === 'asc' ? '▲' : '▼') : '↕' }}</span>
                            </th>
                            <th style="cursor:pointer" wire:click="sortBy('name')">
                                Currency Name <span class="ms-1 text-muted small">{{ $sortField === 'name' ? ($sortDirection === 'asc' ? '▲' : '▼') : '↕' }}</span>
                            </th>
                            <th style="cursor:pointer" wire:click="sortBy('code')">
                                Code <span class="ms-1 text-muted small">{{ $sortField === 'code' ? ($sortDirection === 'asc' ? '▲' : '▼') : '↕' }}</span>
                            </th>
                            <th>Symbol</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($currencies as $currency)
                        <tr>
                            <td class="text-muted">#{{ $currency->id }}</td>
                            <td><span class="fw-bold text-dark">{{ $currency->name }}</span></td>
                            <td><span class="badge bg-light text-primary border">{{ $currency->code }}</span></td>
                            <td><span class="h5 mb-0 text-secondary">{{ $currency->symbol }}</span></td>
                            <td class="text-end">
                                <div class="btn-group shadow-sm">
                                    <button wire:click="edit({{ $currency->id }})" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button onclick="confirm('Delete this currency?') || event.stopImmediatePropagation()"
                                        wire:click="delete({{ $currency->id }})" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No currencies found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $currencies->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div wire:ignore.self class="modal fade" id="currencyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">{{ $isEditMode ? 'Edit Currency' : 'Add New Currency' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="resetFields"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Currency Name</label>
                                <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. US Dollar">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Currency Code</label>
                                <input type="text" wire:model="code" class="form-control @error('code') is-invalid @enderror" placeholder="e.g. USD">
                                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Symbol</label>
                                <input type="text" wire:model="symbol" class="form-control @error('symbol') is-invalid @enderror" placeholder="e.g. $">
                                @error('symbol') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" wire:click="resetFields">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                            {{ $isEditMode ? 'Update Currency' : 'Save Currency' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('hide-modal', event => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('currencyModal'));
            if (modal) modal.hide();
        });
        window.addEventListener('show-modal', event => {
            const modal = new bootstrap.Modal(document.getElementById('currencyModal'));
            modal.show();
        });
    </script>
</div>