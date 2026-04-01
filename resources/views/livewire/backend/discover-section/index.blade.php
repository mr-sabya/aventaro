<div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card shadow-sm border-0">
                    <!-- Header -->
                    <div class="card-header bg-white py-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3 w-45 h-45 d-flex-center">
                                <i class="ri-compass-discover-line fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Discover Section Management</h5>
                                <small class="text-muted">Edit the content and background for the global discovery area</small>
                            </div>
                        </div>
                    </div>

                    <form wire:submit.prevent="save">
                        <div class="card-body p-4">
                            <!-- Success Message -->
                            @if (session()->has('message'))
                            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                                <i class="ri-checkbox-circle-line me-2"></i> {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <div class="row g-4">
                                <!-- Left Column: Background Image -->
                                <div class="col-lg-5 border-end">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold small text-uppercase">Background Image</label>
                                        <div class="image-upload-wrapper" onclick="document.getElementById('discoverBg').click()">
                                            @if ($background_image)
                                            <div class="preview-img-container">
                                                <img src="{{ $background_image->temporaryUrl() }}">
                                            </div>
                                            @elseif($oldImage)
                                            <div class="preview-img-container">
                                                <img src="{{ asset('storage/' . $oldImage) }}">
                                            </div>
                                            @else
                                            <div class="py-4 text-center">
                                                <i class="ri-image-add-line fs-1 text-primary"></i>
                                                <p class="mb-0 small text-muted">Click to select background image</p>
                                            </div>
                                            @endif
                                            <input type="file" id="discoverBg" wire:model="background_image" class="d-none">
                                            <div wire:loading wire:target="background_image" class="mt-2 text-primary small">
                                                <span class="spinner-border spinner-border-sm me-1"></span> Uploading...
                                            </div>
                                            @error('background_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-text mt-2 small">
                                            <i class="ri-information-line me-1"></i> Recommended size: 1920x800px.
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column: Text Content -->
                                <div class="col-lg-7">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-bold small text-uppercase">Subtitle</label>
                                            <input type="text" wire:model="subtitle" class="form-control @error('subtitle') is-invalid @enderror" placeholder="e.g. DISCOVER THE WORLD">
                                            @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold small text-uppercase">Main Title</label>
                                            <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="e.g. Ready for an unforgettable adventure?">
                                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold small text-uppercase">Description</label>
                                            <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Enter the section description..."></textarea>
                                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-uppercase">Button Text</label>
                                            <input type="text" wire:model="button_text" class="form-control" placeholder="e.g. Discover More">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-uppercase">Button URL</label>
                                            <input type="text" wire:model="button_url" class="form-control" placeholder="e.g. /destinations">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="card-footer bg-light py-3 text-end">
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2"></span>
                                <i class="ri-save-3-line me-1"></i> Update Section
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>