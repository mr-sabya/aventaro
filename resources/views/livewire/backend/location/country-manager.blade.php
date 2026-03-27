<div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">Manage Countries</h5>
                <small class="text-muted">Manage countries to set destination country</small>
            </div>
            <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#countryModal" wire:click="resetFields">
                <i class="bi bi-plus-circle me-2"></i>Add Country
            </button>
        </div>

        <div class="card-body">
            @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Search and Filter Bar -->
            <div class="row g-3 mb-4">
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted small">Show</span>
                        <select wire:model.live="perPage" class="form-select">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control border-start-0" placeholder="Search country name..." wire:model.live.debounce.300ms="search">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-v-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="cursor:pointer" wire:click="sortBy('id')" width="80">
                                ID <span class="sort-icon {{ $sortField === 'id' ? 'sort-active' : '' }}">↕</span>
                            </th>
                            <th style="cursor:pointer" wire:click="sortBy('name')">
                                Country Name <span class="sort-icon {{ $sortField === 'name' ? 'sort-active' : '' }}">↕</span>
                            </th>
                            <th>Slug</th>
                            <th class="text-center">Status</th>
                            <th class="text-end" width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($countries as $country)
                        <tr>
                            <td class="text-muted">#{{ $country->id }}</td>
                            <td><span class="fw-semibold">{{ $country->name }}</span></td>
                            <td><code class="small text-muted">{{ $country->slug }}</code></td>
                            <td class="text-center">
                                <div class="form-check form-switch d-inline-block">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        wire:click="toggleStatus({{ $country->id }})"
                                        {{ $country->is_active ? 'checked' : '' }}>
                                </div>
                                <span class="badge rounded-pill {{ $country->is_active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} border">
                                    {{ $country->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <button wire:click="edit({{ $country->id }})" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button onclick="confirm('Delete this country? This might affect cities linked to it.') || event.stopImmediatePropagation()"
                                        wire:click="delete({{ $country->id }})" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-globe-americas fs-1 d-block mb-2"></i>
                                No countries found matching your search.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $countries->links() }}
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="countryModal" tabindex="-1" aria-labelledby="countryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold" id="countryModalLabel">{{ $isEditMode ? 'Edit Country' : 'New Country' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="resetFields"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Country Name</label>
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. United Kingdom">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" wire:model="is_active" id="modalActive">
                            <label class="form-check-label fw-semibold" for="modalActive">Active Status</label>
                            <div class="form-text">Inactive countries will not be visible to users.</div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" wire:click="resetFields">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                            {{ $isEditMode ? 'Save Changes' : 'Create Country' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('hide-modal', event => {
            bootstrap.Modal.getInstance(document.getElementById('countryModal')).hide();
        });
        window.addEventListener('show-modal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('countryModal'));
            myModal.show();
        });
    </script>
</div>