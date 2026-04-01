<div>
    <div class="row g-4">
        <!-- Left Side: Add/Edit Form -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-dark">
                        {{ $isEditMode ? 'Edit Day Plan' : 'Add New Day' }}
                    </h6>
                </div>
                <form wire:submit.prevent="save">
                    <div class="card-body">
                        @if (session()->has('message'))
                        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Day Number</label>
                            <input type="number" wire:model="day_number" class="form-control @error('day_number') is-invalid @enderror">
                            @error('day_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Day Title</label>
                            <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="e.g. Arrival and City Tour">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Description / Activities</label>
                            <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" rows="6" placeholder="Describe the activities for this day..."></textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="card-footer bg-light border-0 py-3">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary shadow-sm">
                                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                                <i class="bi bi-save me-1"></i> {{ $isEditMode ? 'Update Plan' : 'Add to Itinerary' }}
                            </button>
                            @if($isEditMode)
                            <button type="button" wire:click="resetFields" class="btn btn-outline-secondary">Cancel Edit</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Side: Itinerary List -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-dark">Current Itinerary Roadmap</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="100">Day</th>
                                    <th>Activity Detail</th>
                                    <th class="text-end" width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($plans as $plan)
                                <tr class="{{ $planId == $plan->id ? 'table-primary-subtle' : '' }}">
                                    <td class="text-center">
                                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 40px; height: 40px;">
                                            {{ $plan->day_number }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $plan->title }}</div>
                                        <p class="text-muted small mb-0 mt-1 line-clamp-2">
                                            {{ Str::limit($plan->description, 150) }}
                                        </p>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group shadow-sm">
                                            <button wire:click="edit({{ $plan->id }})" class="btn btn-sm btn-white border border-end-0 text-primary">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button onclick="confirm('Remove Day {{ $plan->day_number }} from itinerary?') || event.stopImmediatePropagation()"
                                                wire:click="delete({{ $plan->id }})"
                                                class="btn btn-sm btn-white border text-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                                        No itinerary plans created yet.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Timeline Preview Hint -->
            <div class="alert alert-info border-0 shadow-sm mt-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-lightbulb-fill fs-4 me-3"></i>
                    <p class="mb-0 small">
                        <strong>Tip:</strong> The day plans will be displayed as a timeline on the frontend. Ensure your "Day Number" sequence is logical for the travelers.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>