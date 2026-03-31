<div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">Destinations Management</h5>
                <small class="text-muted">Create and manage travel destinations</small>
            </div>
            <button class="btn btn-primary px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#destModal" wire:click="resetFields">
                <i class="bi bi-plus-lg me-2"></i>Add Destination
            </button>
        </div>

        <div class="card-body">
            @if (session()->has('message'))
            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="row g-3 mb-4">
                <div class="col-md-2">
                    <select wire:model.live="perPage" class="form-select">
                        <option value="10">10 Per Page</option>
                        <option value="25">25 Per Page</option>
                    </select>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control border-start-0" placeholder="Search destination..." wire:model.live.debounce.300ms="search">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="cursor:pointer" wire:click="sortBy('name')">Name ↕</th>
                            <th>City & Country</th>
                            <th>Currency</th>
                            <th>Trending</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($destinations as $dest)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . $dest->image) }}" class="rounded me-3" width="60" height="45" style="object-fit: cover;">
                                    <div>
                                        <div class="fw-bold">{{ $dest->name }}</div>
                                        <small class="text-muted">{{ $dest->slug }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>{{ $dest->city->name }}</div>
                                <small class="badge bg-light text-dark border">{{ $dest->city->country->name }}</small>
                            </td>
                            <td><span class="text-primary fw-bold">{{ $dest->currency->code }}</span> ({{ $dest->currency->symbol }})</td>
                            <td>
                                @if($dest->is_trending)
                                <span class="badge bg-warning text-dark"><i class="bi bi-fire me-1"></i>Trending</span>
                                @else
                                <span class="text-muted small">No</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $dest->is_active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} border">
                                    {{ $dest->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group shadow-sm">
                                    <button wire:click="edit({{ $dest->id }})" class="btn btn-sm btn-white border text-primary"><i class="bi bi-pencil-square"></i></button>
                                    <button onclick="confirm('Delete this destination?') || event.stopImmediatePropagation()" wire:click="delete({{ $dest->id }})" class="btn btn-sm btn-white border text-danger"><i class="bi bi-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No destinations found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $destinations->links() }}
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="destModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">{{ $isEditMode ? 'Edit Destination' : 'New Destination' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="resetFields"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="row g-4">
                            <!-- Sidebar: Image & Assignments -->
                            <div class="col-lg-4 border-end">
                                <!-- Image Upload -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-uppercase">Cover Image</label>
                                    <div class="image-upload-wrapper" onclick="document.getElementById('destImg').click()">
                                        @if ($image)
                                        <div class="preview-img-container">
                                            <img src="{{ $image->temporaryUrl() }}">
                                        </div>
                                        @elseif($oldImage)
                                        <div class="preview-img-container">
                                            <img src="{{ asset('storage/' . $oldImage) }}">
                                        </div>
                                        @else
                                        <div class="py-3">
                                            <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>
                                            <p class="mb-0 small text-muted">Click to select image</p>
                                        </div>
                                        @endif
                                        <input type="file" id="destImg" wire:model="image" class="d-none">
                                        <div wire:loading wire:target="image" class="mt-2 text-primary small">Uploading...</div>
                                        @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Languages -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-uppercase">Spoken Languages</label>
                                    <div class="multi-select-box">
                                        @foreach($languages as $lang)
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" value="{{ $lang->id }}" wire:model="selectedLanguages" id="lang{{ $lang->id }}">
                                            <label class="form-check-label small" for="lang{{ $lang->id }}">{{ $lang->name }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- FAQ Assignment -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-uppercase">Assign FAQs</label>
                                    <div class="multi-select-box">
                                        @foreach($allFaqs as $faq)
                                        <div class="form-check border-bottom py-1">
                                            <input class="form-check-input" type="checkbox" value="{{ $faq->id }}" wire:model="selectedFaqs" id="faq{{ $faq->id }}">
                                            <label class="form-check-label small" for="faq{{ $faq->id }}">{{ $faq->question }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Main Content -->
                            <div class="col-lg-8">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Destination Name</label>
                                        <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror">
                                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Country Dropdown (New) -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Country</label>
                                        <select wire:model.live="selected_country_id" class="form-select @error('selected_country_id') is-invalid @enderror">
                                            <option value="">-- Select Country --</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('selected_country_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Dependent City Dropdown -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">City</label>
                                        <select wire:model="city_id" class="form-select @error('city_id') is-invalid @enderror" {{ empty($selected_country_id) ? 'disabled' : '' }}>
                                            <option value="">
                                                @if(empty($selected_country_id))
                                                -- Select Country First --
                                                @else
                                                -- Select City --
                                                @endif
                                            </option>
                                            @foreach($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        @if(!empty($selected_country_id) && $cities->isEmpty())
                                        <small class="text-danger">No cities found for this country.</small>
                                        @endif
                                        @error('city_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Currency</label>
                                        <select wire:model="currency_id" class="form-select @error('currency_id') is-invalid @enderror">
                                            <option value="">Select Currency</option>
                                            @foreach($currencies as $curr) <option value="{{ $curr->id }}">{{ $curr->name }} ({{ $curr->symbol }})</option> @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Total Area (sq km)</label>
                                        <input type="text" wire:model="area" class="form-control" placeholder="e.g. 1,572 km²">
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Map Embed URL (Iframe src)</label>
                                        <input type="text" wire:model="map_embed_url" class="form-control" placeholder="https://google.com/maps/embed/...">
                                    </div>

                                    <!-- Dynamic Features -->
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Key Features</label>
                                        <div class="feature-input-group">
                                            @foreach($features as $index => $feature)
                                            <div class="input-group mb-2 shadow-sm">
                                                <input type="text" wire:model="features.{{ $index }}" class="form-control border-0" placeholder="e.g. Free Visa on Arrival">
                                                <button type="button" class="btn btn-white text-danger border-start" wire:click="removeFeature({{ $index }})"><i class="bi bi-x-lg"></i></button>
                                            </div>
                                            @endforeach
                                            <button type="button" class="btn btn-sm btn-primary mt-2 shadow-sm" wire:click="addFeature"><i class="bi bi-plus-circle me-1"></i>Add Feature Item</button>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold">Visa Requirements</label>
                                        <textarea wire:model="visa_requirements" class="form-control" rows="2"></textarea>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold">Short Description</label>
                                        <textarea wire:model="description" class="form-control" rows="3"></textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch p-3 border rounded">
                                            <input class="form-check-input ms-0 me-2" type="checkbox" wire:model="is_trending" id="trendSw">
                                            <label class="form-check-label fw-bold" for="trendSw text-warning">Mark as Trending</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch p-3 border rounded bg-light">
                                            <input class="form-check-input ms-0 me-2" type="checkbox" wire:model="is_active" id="activeSw">
                                            <label class="form-check-label fw-bold" for="activeSw">Visibility Status</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top-0 py-3">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" wire:click="resetFields">Cancel</button>
                        <button type="submit" class="btn btn-primary px-5 shadow">
                            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                            {{ $isEditMode ? 'Update Destination' : 'Create Destination' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('hide-modal', () => bootstrap.Modal.getInstance(document.getElementById('destModal')).hide());
        window.addEventListener('show-modal', () => new bootstrap.Modal(document.getElementById('destModal')).show());
    </script>
</div>