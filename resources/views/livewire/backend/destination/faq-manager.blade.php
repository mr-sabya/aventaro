<div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">Destination FAQs</h5>
            <button class="btn btn-dark" wire:click="resetFields" data-bs-toggle="modal" data-bs-target="#faqModal">New FAQ</button>
        </div>
        <div class="card-body">
            <input type="text" class="form-control mb-3" placeholder="Search questions..." wire:model.live="search">

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Question</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($faqs as $faq)
                        <tr>
                            <td><strong>{{ $faq->question }}</strong></td>
                            <td><span class="badge {{ $faq->is_active ? 'bg-success' : 'bg-danger' }}">{{ $faq->is_active ? 'Active' : 'Inactive' }}</span></td>
                            <td class="text-end">
                                <button wire:click="edit({{ $faq->id }})" class="btn btn-sm btn-light border">Edit</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $faqs->links() }}
            </div>
        </div>
    </div>

    <!-- FAQ Modal -->
    <div wire:ignore.self class="modal fade" id="faqModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="save">
                    <div class="modal-header">
                        <h5 class="modal-title">FAQ Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Question</label>
                            <input type="text" wire:model="question" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Answer</label>
                            <textarea wire:model="answer" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" wire:model="is_active">
                            <label class="form-check-label">Visible</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">Save FAQ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('hide-faq-modal', () => bootstrap.Modal.getInstance(document.getElementById('faqModal')).hide());
        window.addEventListener('show-faq-modal', () => new bootstrap.Modal(document.getElementById('faqModal')).show());
    </script>
</div>