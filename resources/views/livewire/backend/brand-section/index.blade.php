<div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-tag me-2 text-primary"></i>Brand Section Management</h5>
                        <small class="text-muted">This text usually appears as a heading or description above the partner logo slider.</small>
                    </div>

                    <form wire:submit.prevent="save">
                        <div class="card-body">
                            @if (session()->has('message'))
                            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i> {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase">Section Heading / Text</label>
                                <textarea
                                    wire:model="text"
                                    class="form-control @error('text') is-invalid @enderror"
                                    rows="4"
                                    placeholder="e.g. We are proud to work with the world's leading travel partners and airlines."></textarea>

                                @error('text')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="form-text text-muted">
                                    Recommended: Keep this concise (max 500 characters).
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light py-3 text-end">
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2"></span>
                                <i class="bi bi-save me-2"></i>Update Section
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Helpful Tip for Admin -->
                <div class="alert alert-info border-0 shadow-sm mt-4">
                    <div class="d-flex">
                        <i class="bi bi-lightbulb fs-4 me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Design Tip</h6>
                            <p class="mb-0 small">This text provides context for your partners. Try to use it to build trust with your visitors by mentioning the quality or number of your collaborations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>