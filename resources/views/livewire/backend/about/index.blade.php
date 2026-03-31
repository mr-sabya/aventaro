<div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">About Us Management</h5>
            <small class="text-muted">Update the main content for the website's about section</small>
        </div>

        <form wire:submit.prevent="save">
            <div class="card-body">
                @if (session()->has('message'))
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="row g-4">
                    <!-- Left Column: Image & Features -->
                    <div class="col-lg-4 border-end">
                        <!-- Image Section using your requested template -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">About Section Image</label>
                            <div class="image-upload-wrapper" onclick="document.getElementById('aboutImgInput').click()">
                                @if ($main_image)
                                <div class="preview-img-container">
                                    <img src="{{ $main_image->temporaryUrl() }}">
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
                                <input type="file" id="aboutImgInput" wire:model="main_image" class="d-none">
                                <div wire:loading wire:target="main_image" class="mt-2 text-primary small">Uploading...</div>
                                @error('main_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Features List -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Highlights / Features</label>
                            <div class="bg-light p-3 rounded shadow-sm">
                                @foreach($features as $index => $feature)
                                <div class="input-group mb-2">
                                    <input type="text" wire:model="features.{{ $index }}" class="form-control border-0" placeholder="e.g. Expert Guides">
                                    <button type="button" class="btn btn-white text-danger border-start" wire:click="removeFeature({{ $index }})"><i class="bi bi-x-lg"></i></button>
                                </div>
                                @endforeach
                                <button type="button" class="btn btn-sm btn-primary mt-2" wire:click="addFeature"><i class="bi bi-plus-circle me-1"></i>Add Highlight</button>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Content Fields -->
                    <div class="col-lg-8">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Subtitle</label>
                                <input type="text" wire:model="subtitle" class="form-control" placeholder="e.g. Who We Are">
                                @error('subtitle') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Main Title</label>
                                <input type="text" wire:model="title" class="form-control" placeholder="e.g. Best Travel Agency Since 2010">
                                @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Description</label>
                                <textarea wire:model="description" class="form-control" rows="5"></textarea>
                                @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Quote / Mission</label>
                                <textarea wire:model="quote" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Experience (Years)</label>
                                <input type="number" wire:model="experience_years" class="form-control">
                                @error('experience_years') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Button Text</label>
                                <input type="text" wire:model="button_text" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Button URL</label>
                                <input type="text" wire:model="button_url" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-white py-3 text-end">
                <button type="submit" class="btn btn-primary px-5 shadow-sm">
                    <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2"></span>
                    <i class="bi bi-save me-2"></i>Update About Section
                </button>
            </div>
        </form>
    </div>
</div>