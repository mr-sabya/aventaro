<div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-0 fw-bold text-dark">Language Settings</h5>
                <small class="text-muted">Manage system languages and ISO codes</small>
            </div>
            <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#languageModal" wire:click="resetFields">
                <i class="bi bi-plus-lg me-1"></i> Add New Language
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
                        <input type="text" class="form-control border-start-0" placeholder="Search name or code..." wire:model.live.debounce.300ms="search">
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
                                Language Name <span class="ms-1 text-muted small">{{ $sortField === 'name' ? ($sortDirection === 'asc' ? '▲' : '▼') : '↕' }}</span>
                            </th>
                            <th style="cursor:pointer" wire:click="sortBy('code')">
                                ISO Code <span class="ms-1 text-muted small">{{ $sortField === 'code' ? ($sortDirection === 'asc' ? '▲' : '▼') : '↕' }}</span>
                            </th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($languages as $language)
                        <tr>
                            <td class="text-muted small">#{{ $language->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3 text-primary">
                                        <i class="bi bi-translate"></i>
                                    </div>
                                    <span class="fw-bold text-dark">{{ $language->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary border px-3">
                                    {{ strtoupper($language->code) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group shadow-sm">
                                    <button wire:click="edit({{ $language->id }})" class="btn btn-sm btn-white border" title="Edit">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </button>
                                    <button onclick="confirm('Delete this language?') || event.stopImmediatePropagation()"
                                        wire:click="delete({{ $language->id }})" class="btn btn-sm btn-white border" title="Delete">
                                        <i class="bi bi-trash text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-chat-left-dots fs-1 d-block mb-2"></i>
                                No languages found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $languages->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div wire:ignore.self class="modal fade" id="languageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">
                        {{ $isEditMode ? 'Edit Language' : 'Create New Language' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="resetFields"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body pt-0">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Language Name</label>
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. English">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">ISO Code / Short Code</label>
                            <input type="text" wire:model="code" class="form-control @error('code') is-invalid @enderror" placeholder="e.g. EN or ENG">
                            <div class="form-text text-muted">Usually a 2 or 3 letter code.</div>
                            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" wire:click="resetFields">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                            {{ $isEditMode ? 'Update Language' : 'Save Language' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('hide-modal', event => {
            const modalElement = document.getElementById('languageModal');
            const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
            modalInstance.hide();
        });
        window.addEventListener('show-modal', event => {
            const modalElement = document.getElementById('languageModal');
            const modalInstance = new bootstrap.Modal(modalElement);
            modalInstance.show();
        });
    </script>
</div>