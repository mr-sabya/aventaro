<div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <!-- Header -->
                    <div class="card-header bg-white py-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3 w-45 h-45 d-flex-center">
                                <i class="ri-magic-line fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold text-dark">Featured Tour Section</h5>
                                <small class="text-muted">Edit the text content for the homepage featured tours area</small>
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
                                <!-- Subtitle Input -->
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-uppercase">Section Subtitle</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="ri-font-size-2 text-muted"></i></span>
                                        <input type="text" wire:model="subtitle" class="form-control border-start-0 @error('subtitle') is-invalid @enderror" placeholder="e.g. Featured Tours">
                                    </div>
                                    @error('subtitle') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <!-- Title Input -->
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-uppercase">Main Title</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="ri-heading text-muted"></i></span>
                                        <input type="text" wire:model="title" class="form-control border-start-0 @error('title') is-invalid @enderror" placeholder="e.g. Our Best Hand-Picked Tours">
                                    </div>
                                    @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <!-- Description Textarea -->
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-uppercase">Section Description</label>
                                    <textarea
                                        wire:model="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        rows="5"
                                        placeholder="Enter a brief intro for this section..."></textarea>
                                    @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer with Save Button -->
                        <div class="card-footer bg-light border-top-0 py-3 text-end">
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2"></span>
                                <i class="ri-save-3-line me-1" wire:loading.remove wire:target="save"></i>
                                Save Content
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Footer Context Info -->
                <div class="alert alert-info border-0 shadow-sm mt-4">
                    <div class="d-flex">
                        <i class="ri-information-line fs-4 me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">How this works</h6>
                            <p class="mb-0 small text-dark opacity-75">
                                This section manages the textual introduction on the homepage.
                                Tours that have been marked as <strong>"Is Featured"</strong> will automatically appear underneath this text.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>