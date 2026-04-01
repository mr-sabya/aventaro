<div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">

                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-danger bg-opacity-10 p-2 me-3 w-45 h-45 d-flex-center">
                                <i class="ri-fire-line fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold text-dark">Trending Section Settings</h5>
                                <small class="text-muted">Manage the header content for the trending destinations area.</small>
                            </div>
                        </div>
                    </div>

                    <form wire:submit.prevent="save">
                        <div class="card-body">
                            @if (session()->has('message'))
                            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i> {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small text-uppercase">Section Subtitle</label>
                                    <input type="text" wire:model="subtitle" class="form-control @error('subtitle') is-invalid @enderror" placeholder="e.g. Trending Destinations">
                                    @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold small text-uppercase">Main Title</label>
                                    <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="e.g. Trendy Travel Locations">
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-uppercase">Button Text</label>
                                    <input type="text" wire:model="button_text" class="form-control @error('button_text') is-invalid @enderror" placeholder="Explore More">
                                    @error('button_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-uppercase">Button URL</label>
                                    <input type="text" wire:model="button_url" class="form-control @error('button_url') is-invalid @enderror" placeholder="/destinations">
                                    @error('button_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light py-3 text-end">
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2"></span>
                                <i class="bi bi-save me-2"></i>Update Trending Section
                            </button>
                        </div>
                    </form>
                </div>

                <div class="alert alert-warning border-0 shadow-sm mt-4">
                    <div class="d-flex">
                        <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Note</h6>
                            <p class="mb-0 small text-dark">This content controls the intro text above the destinations marked as "Trending" in your database. Ensure the Button URL is a valid internal path or full URL.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>