<div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-0 fw-bold">Partner Management</h5>
                <small class="text-muted">Manage brand logos and partner links</small>
            </div>
            <button class="btn btn-primary px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#partnerModal" wire:click="resetFields">
                <i class="bi bi-plus-lg me-1"></i> Add Partner
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
                        <input type="text" class="form-control border-start-0" placeholder="Search partners..." wire:model.live.debounce.300ms="search">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="cursor:pointer" wire:click="sortBy('sort_order')" width="100">
                                Order <span class="ms-1 text-muted small">{{ $sortField === 'sort_order' ? ($sortDirection === 'asc' ? '▲' : '▼') : '↕' }}</span>
                            </th>
                            <th>Logo</th>
                            <th style="cursor:pointer" wire:click="sortBy('name')">
                                Partner Name <span class="ms-1 text-muted small">{{ $sortField === 'name' ? ($sortDirection === 'asc' ? '▲' : '▼') : '↕' }}</span>
                            </th>
                            <th>Website URL</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($partners as $partner)
                        <tr>
                            <td><span class="badge bg-light text-dark border">{{ $partner->sort_order }}</span></td>
                            <td>
                                <div class="rounded border p-1 bg-light d-inline-block">
                                    <img src="{{ asset('storage/' . $partner->image) }}" width="80" height="40" style="object-fit: contain;">
                                </div>
                            </td>
                            <td><span class="fw-bold text-dark">{{ $partner->name }}</span></td>
                            <td>
                                @if($partner->url)
                                <a href="{{ $partner->url }}" target="_blank" class="text-decoration-none small text-truncate d-inline-block" style="max-width: 200px;">
                                    <i class="bi bi-link-45deg"></i> {{ $partner->url }}
                                </a>
                                @else
                                <span class="text-muted small">No link</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill {{ $partner->is_active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} border px-3">
                                    {{ $partner->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group shadow-sm">
                                    <button wire:click="edit({{ $partner->id }})" class="btn btn-sm btn-white border" title="Edit">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </button>
                                    <button onclick="confirm('Delete this partner?') || event.stopImmediatePropagation()"
                                        wire:click="delete({{ $partner->id }})" class="btn btn-sm btn-white border" title="Delete">
                                        <i class="bi bi-trash text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No partners found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $partners->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div wire:ignore.self class="modal fade" id="partnerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">{{ $isEditMode ? 'Edit Partner' : 'Add New Partner' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="resetFields"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body pt-0">
                        <div class="row g-3">
                            <!-- Image Section -->
                            <div class="col-12">
                                <label class="form-label fw-bold small text-uppercase">Partner Logo</label>
                                <div class="image-upload-wrapper" onclick="document.getElementById('partnerImgInput').click()">
                                    @if ($image)
                                    <div class="preview-img-container">
                                        <img src="{{ $image->temporaryUrl() }}">
                                    </div>
                                    @elseif($oldImage)
                                    <div class="preview-img-container">
                                        <img src="{{ asset('storage/' . $oldImage) }}">
                                    </div>
                                    @else
                                    <div class="py-3 text-center">
                                        <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>
                                        <p class="mb-0 small text-muted">Click to select logo</p>
                                    </div>
                                    @endif
                                    <input type="file" id="partnerImgInput" wire:model="image" class="d-none">
                                    <div wire:loading wire:target="image" class="mt-2 text-primary small">Uploading...</div>
                                    @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Partner Name</label>
                                <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Emirates Airlines">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Website URL (Optional)</label>
                                <input type="text" wire:model="url" class="form-control @error('url') is-invalid @enderror" placeholder="https://...">
                                @error('url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Sort Order</label>
                                <input type="number" wire:model="sort_order" class="form-control @error('sort_order') is-invalid @enderror">
                                @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-check form-switch p-3 bg-light rounded shadow-sm">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" wire:model="is_active" id="modalPartnerActive">
                                    <label class="form-check-label fw-bold" for="modalPartnerActive">Active Status</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" wire:click="resetFields">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                            {{ $isEditMode ? 'Update Partner' : 'Save Partner' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('hide-modal', event => {
            const modalElement = document.getElementById('partnerModal');
            const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
            modalInstance.hide();
        });
        window.addEventListener('show-modal', event => {
            const modalElement = document.getElementById('partnerModal');
            const modalInstance = new bootstrap.Modal(modalElement);
            modalInstance.show();
        });
    </script>
</div>