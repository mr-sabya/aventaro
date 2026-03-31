<div>

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Hero Slides Management</h5>
                <small class="text-muted">Manage hero slider for website hero section</small>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#slideModal" wire:click="resetFields">
                <i class="bi bi-plus-lg"></i> Add New Slide
            </button>
        </div>

        <div class="card-body">
            @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="row mb-3">
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
                    <input type="text" class="form-control" placeholder="Search slides..." wire:model.live.debounce.300ms="search">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="cursor:pointer" wire:click="sortBy('order')">
                                Order <span class="sort-icon {{ $sortField === 'order' ? 'sort-active' : '' }}">▲▼</span>
                            </th>
                            <th>Image</th>
                            <th style="cursor:pointer" wire:click="sortBy('title_part_1')">
                                Title <span class="sort-icon {{ $sortField === 'title_part_1' ? 'sort-active' : '' }}">▲▼</span>
                            </th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($slides as $slide)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $slide->order }}</span></td>
                            <td>
                                <img src="{{ asset('storage/' . $slide->background_image) }}" class="rounded" width="80" alt="slide">
                            </td>
                            <td>
                                <strong>{{ $slide->title_part_1 }}</strong><br>
                                <small class="text-muted">{{ $slide->subtitle }}</small>
                            </td>
                            <td>
                                <span class="badge {{ $slide->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $slide->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <button wire:click="edit({{ $slide->id }})" class="btn btn-sm btn-outline-primary">Edit</button>
                                <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="delete({{ $slide->id }})" class="btn btn-sm btn-outline-danger">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No slides found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $slides->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    <div wire:ignore.self class="modal fade" id="slideModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $isEditMode ? 'Edit Hero Slide' : 'Add New Hero Slide' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="resetFields"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Background Image</label>
                                <div class="image-upload-wrapper" onclick="document.getElementById('fileUpload').click()">
                                    @if ($background_image)
                                    <div class="preview-img-container">
                                        <img src="{{ $background_image->temporaryUrl() }}" class="preview-img">
                                    </div>
                                    @elseif($oldImage)
                                    <div class="preview-img-container">
                                        <img src="{{ asset('storage/' . $oldImage) }}" class="preview-img">
                                    </div>
                                    @else
                                    <div class="py-4 text-muted">
                                        <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>
                                        <p class="mb-0 small text-muted">Click to select image</p>
                                    </div>
                                    @endif
                                    <input type="file" id="fileUpload" wire:model="background_image" class="d-none">
                                    <div wire:loading wire:target="background_image" class="mt-2 text-primary">Uploading...</div>
                                    @error('background_image') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Subtitle</label>
                                <input type="text" wire:model="subtitle" class="form-control">
                                @error('subtitle') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Order</label>
                                <input type="number" wire:model="order" class="form-control">
                                @error('order') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Title Part 1</label>
                                <input type="text" wire:model="title_part_1" class="form-control" placeholder="Explore">
                                @error('title_part_1') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Title Part 2</label>
                                <input type="text" wire:model="title_part_2" class="form-control" placeholder="The">
                                @error('title_part_2') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Title Part 3</label>
                                <input type="text" wire:model="title_part_3" class="form-control" placeholder="Global Worlds">
                                @error('title_part_3') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea wire:model="description" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" wire:model="is_active" id="isActiveSwitch">
                                    <label class="form-check-label" for="isActiveSwitch">Active Status</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetFields">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            {{ $isEditMode ? 'Update Slide' : 'Create Slide' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('hide-modal', event => {
            bootstrap.Modal.getInstance(document.getElementById('slideModal')).hide();
        });
        window.addEventListener('show-modal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('slideModal'));
            myModal.show();
        });
    </script>
</div>