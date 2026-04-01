<div>
    <div class="container-fluid mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-bold text-dark">Tour Packages</h5>
                    <small class="text-muted">Manage your tour itineraries and pricing</small>
                </div>
                <button class="btn btn-primary px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#tourModal" wire:click="resetFields">
                    <i class="ri-add-circle-line me-2"></i>Create New Tour
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
                        <select wire:model.live="perPage" class="form-select border-0 bg-light shadow-sm">
                            <option value="10">10 Per Page</option>
                            <option value="25">25 Per Page</option>
                        </select>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-4">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" class="form-control border-start-0" placeholder="Search tour title..." wire:model.live.debounce.300ms="search">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="cursor:pointer" wire:click="sortBy('title')">Tour Info ↕</th>
                                <th>Location</th>
                                <th style="cursor:pointer" wire:click="sortBy('price')">Price ↕</th>
                                <th>Meta</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tours as $tour)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $tour->thumbnail_image) }}" class="rounded me-3" width="70" height="50" style="object-fit: cover;">
                                        <div>
                                            <div class="fw-bold text-dark">{{ $tour->title }}</div>
                                            <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $tour->duration }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small fw-bold">{{ $tour->city->name }}</div>
                                    <div class="small text-muted">{{ $tour->city->country->name }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary">${{ number_format($tour->price, 2) }}</div>
                                    @if($tour->old_price)
                                    <del class="text-muted small">${{ number_format($tour->old_price, 2) }}</del>
                                    @endif
                                </td>
                                <td>
                                    @if($tour->is_featured) <span class="badge bg-info-subtle text-info border">Featured</span> @endif
                                    @if($tour->is_hot_deal) <span class="badge bg-danger-subtle text-danger border">Hot Deal</span> @endif
                                </td>
                                <td>
                                    <span class="badge {{ $tour->is_active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} border">
                                        {{ $tour->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group shadow-sm">
                                        <a href="{{ route('admin.tours.plans', $tour->id) }}" class="btn btn-sm btn-white border text-dark" title="Manage Itinerary">
                                            <i class="ri-calendar-2-line"></i>
                                        </a>
                                        <button wire:click="edit({{ $tour->id }})" class="btn btn-sm btn-white border text-primary" title="Edit">
                                            <i class="ri-pencil-line"></i>
                                        </button>
                                        <button onclick="confirm('Delete this tour?') || event.stopImmediatePropagation()" wire:click="delete({{ $tour->id }})" class="btn btn-sm btn-white border text-danger" title="Delete">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">No tours found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $tours->links() }}
            </div>
        </div>
    </div>

    <!-- Tour Modal -->
    <div wire:ignore.self class="modal fade" id="tourModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold text-dark">{{ $isEditMode ? 'Edit Tour Package' : 'Create New Tour' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="resetFields"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <!-- Left Sidebar: Images & Amenities -->
                            <div class="col-lg-4 border-end">
                                <!-- Thumbnail -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-uppercase">Thumbnail (Grid View)</label>
                                    <div class="image-upload-wrapper" onclick="document.getElementById('thumbImg').click()">
                                        @if ($thumbnail_image)
                                        <div class="preview-img-container"><img src="{{ $thumbnail_image->temporaryUrl() }}"></div>
                                        @elseif($old_thumbnail)
                                        <div class="preview-img-container"><img src="{{ asset('storage/' . $old_thumbnail) }}"></div>
                                        @else
                                        <div class="py-3"><i class="bi bi-image fs-1 text-primary"></i>
                                            <p class="mb-0 small text-muted">Click to select</p>
                                        </div>
                                        @endif
                                        <input type="file" id="thumbImg" wire:model="thumbnail_image" class="d-none">
                                        @error('thumbnail_image') <div class="text-danger small">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Details Image -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-uppercase">Detail Page Image</label>
                                    <div class="image-upload-wrapper" onclick="document.getElementById('detailImg').click()">
                                        @if ($details_image)
                                        <div class="preview-img-container"><img src="{{ $details_image->temporaryUrl() }}"></div>
                                        @elseif($old_details)
                                        <div class="preview-img-container"><img src="{{ asset('storage/' . $old_details) }}"></div>
                                        @else
                                        <div class="py-3"><i class="bi bi-images fs-1 text-primary"></i>
                                            <p class="mb-0 small text-muted">Click to select</p>
                                        </div>
                                        @endif
                                        <input type="file" id="detailImg" wire:model="details_image" class="d-none">
                                        @error('details_image') <div class="text-danger small">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Amenities -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-uppercase">Amenities Included</label>
                                    <div class="border p-3 rounded bg-light" style="max-height: 250px; overflow-y: auto;">
                                        @foreach($allAmenities as $am)
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" value="{{ $am->id }}" wire:model="selectedAmenities" id="am{{ $am->id }}">
                                            <label class="form-check-label small" for="am{{ $am->id }}">{{ $am->name }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Main Content Area -->
                            <div class="col-lg-8">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Tour Title</label>
                                        <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Country</label>
                                        <select wire:model.live="selected_country_id" class="form-select @error('selected_country_id') is-invalid @enderror">
                                            <option value="">-- Select Country --</option>
                                            @foreach($countries as $country) <option value="{{ $country->id }}">{{ $country->name }}</option> @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">City</label>
                                        <select wire:model="city_id" class="form-select @error('city_id') is-invalid @enderror" {{ empty($selected_country_id) ? 'disabled' : '' }}>
                                            <option value="">-- Select City --</option>
                                            @foreach($cities as $city) <option value="{{ $city->id }}">{{ $city->name }}</option> @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Price ($)</label>
                                        <input type="number" wire:model="price" class="form-control">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Old Price ($)</label>
                                        <input type="number" wire:model="old_price" class="form-control">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Duration</label>
                                        <input type="text" wire:model="duration" class="form-control" placeholder="e.g. 5 Days / 4 Nights">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Countries Covered</label>
                                        <input type="text" wire:model="countries_covered" class="form-control" placeholder="e.g. Italy, France, Spain">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Map Embed URL</label>
                                        <input type="text" wire:model="map_embed_url" class="form-control">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold">Address / Meeting Point</label>
                                        <input type="text" wire:model="address" class="form-control">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold">Description</label>
                                        <textarea wire:model="description" class="form-control" rows="4"></textarea>
                                    </div>

                                    <!-- Features JSON -->
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Highlights / Special Features</label>
                                        <div class="p-3 bg-light rounded">
                                            @foreach($features as $index => $feature)
                                            <div class="input-group mb-2 shadow-sm">
                                                <input type="text" wire:model="features.{{ $index }}" class="form-control border-0" placeholder="Feature detail...">
                                                <button type="button" class="btn btn-white text-danger border-start" wire:click="removeFeature({{ $index }})"><i class="ri-close-line"></i></button>
                                            </div>
                                            @endforeach
                                            <button type="button" class="btn btn-sm btn-primary mt-2 shadow-sm" wire:click="addFeature"><i class="ri-add-circle-line me-2"></i></i>Add Highlight Item</button>
                                        </div>
                                    </div>

                                    <!-- Status Toggles -->
                                    <div class="col-md-4">
                                        <div class="form-check form-switch p-3 border rounded shadow-sm">
                                            <input class="form-check-input ms-0 me-2" type="checkbox" wire:model="is_featured" id="featSw">
                                            <label class="form-check-label fw-bold" for="featSw">Featured Tour</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch p-3 border rounded shadow-sm bg-danger-subtle">
                                            <input class="form-check-input ms-0 me-2" type="checkbox" wire:model="is_hot_deal" id="hotSw">
                                            <label class="form-check-label fw-bold text-danger" for="hotSw">Hot Deal</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch p-3 border rounded shadow-sm bg-success-subtle">
                                            <input class="form-check-input ms-0 me-2" type="checkbox" wire:model="is_active" id="actSw">
                                            <label class="form-check-label fw-bold text-success" for="actSw">Active Status</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top-0 py-3">
                        <button type="button" class="btn btn-outline-secondary px-4 shadow-sm" data-bs-dismiss="modal" wire:click="resetFields">Cancel</button>
                        <button type="submit" class="btn btn-primary px-5 shadow">
                            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                            {{ $isEditMode ? 'Update Tour' : 'Create Tour' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('hide-modal', () => bootstrap.Modal.getInstance(document.getElementById('tourModal')).hide());
        window.addEventListener('show-modal', () => new bootstrap.Modal(document.getElementById('tourModal')).show());
    </script>
</div>