<div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">Manage Cities</h5>
                <small class="text-muted">Manage urban destinations and their country assignments</small>
            </div>
            <button class="btn btn-primary px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#cityModal" wire:click="resetFields">
                <i class="bi bi-plus-circle me-2"></i>Add New City
            </button>
        </div>

        <div class="card-body">
            @if (session()->has('message'))
            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Datatable Controls -->
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
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" class="form-control border-start-0" placeholder="Search city or country..." wire:model.live.debounce.300ms="search">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-v-middle">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th style="cursor:pointer" wire:click="sortBy('id')" width="70">
                                ID <span class="sort-icon {{ $sortField === 'id' ? 'sort-active' : '' }}">↕</span>
                            </th>
                            <th style="cursor:pointer" wire:click="sortBy('name')">
                                City Name <span class="sort-icon {{ $sortField === 'name' ? 'sort-active' : '' }}">↕</span>
                            </th>
                            <th>Country</th>
                            <th>Slug</th>
                            <th class="text-center">Status</th>
                            <th class="text-end" width="130">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cities as $city)
                        <tr>
                            <td class="text-muted small">#{{ $city->id }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $city->name }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border"><i class="bi bi-geo-alt me-1"></i>{{ $city->country->name }}</span>
                            </td>
                            <td><code class="small text-muted">{{ $city->slug }}</code></td>
                            <td class="text-center">
                                <div class="form-check form-switch d-inline-block">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        wire:click="toggleStatus({{ $city->id }})"
                                        {{ $city->is_active ? 'checked' : '' }}>
                                </div>
                                <small class="d-block {{ $city->is_active ? 'text-success' : 'text-danger' }} fw-bold" style="font-size: 0.7rem;">
                                    {{ $city->is_active ? 'ACTIVE' : 'INACTIVE' }}
                                </small>
                            </td>
                            <td class="text-end">
                                <div class="btn-group shadow-sm">
                                    <button wire:click="edit({{ $city->id }})" class="btn btn-sm btn-white border" title="Edit">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </button>
                                    <button onclick="confirm('Are you sure you want to delete this city?') || event.stopImmediatePropagation()"
                                        wire:click="delete({{ $city->id }})" class="btn btn-sm btn-white border" title="Delete">
                                        <i class="bi bi-trash text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-building-exclamation fs-1 d-block mb-2"></i>
                                No cities found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $cities->links() }}
            </div>
        </div>
    </div>


    <!-- Modal Form -->
    <div wire:ignore.self class="modal fade" id="cityModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">{{ $isEditMode ? 'Edit City' : 'Create New City' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="resetFields"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <!-- Country Select -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Select Country</label>
                            <select wire:model="country_id" class="form-select @error('country_id') is-invalid @enderror">
                                <option value="">-- Choose Country --</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                            @error('country_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- City Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">City Name</label>
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. London">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Active Switch -->
                        <div class="form-check form-switch mt-4 p-3 bg-light rounded shadow-sm">
                            <input class="form-check-input ms-0 me-2" type="checkbox" wire:model="is_active" id="modalCityActive">
                            <label class="form-check-label fw-bold" for="modalCityActive">City Active Status</label>
                            <div class="form-text mt-0 ms-4">When disabled, this city will be hidden from public filters.</div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" wire:click="resetFields">Close</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                            {{ $isEditMode ? 'Update City' : 'Create City' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('hide-modal', event => {
            const modalElement = document.getElementById('cityModal');
            const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
            modalInstance.hide();
        });
        window.addEventListener('show-modal', event => {
            const modalElement = document.getElementById('cityModal');
            const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
            modalInstance.show();
        });
    </script>
</div>