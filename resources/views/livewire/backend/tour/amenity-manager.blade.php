<div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between">
            <div>
                <h5 class="mb-0 fw-bold">Tour Amenities</h5>
                <small class="text-muted">Manage your tour itineraries and pricing</small>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#amenityModal" wire:click="resetFields">Add Amenity</button>
        </div>
        <div class="card-body">
            <input type="text" class="form-control mb-3" placeholder="Search..." wire:model.live="search">
            <table class="table align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($amenities as $item)
                    <tr>
                        <td><i class="{{ $item->icon_class }} fs-4"></i></td>
                        <td>{{ $item->name }}</td>
                        <td><code>{{ $item->icon_class }}</code></td>
                        <td class="text-end">
                            <button wire:click="edit({{ $item->id }})" class="btn btn-sm btn-outline-primary">Edit</button>
                            <button onclick="confirm('Delete?') || event.stopImmediatePropagation()" wire:click="delete({{ $item->id }})" class="btn btn-sm btn-outline-danger">Delete</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-3 text-muted">No amenities found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $amenities->links() }}
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="amenityModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="save">
                    <div class="modal-header">
                        <h5>Amenity Details</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" wire:model="name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Icon Class (FontAwesome/Bootstrap)</label>
                            <input type="text" wire:model="icon_class" class="form-control" placeholder="fa fa-wifi">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('hide-modal', () => bootstrap.Modal.getInstance(document.getElementById('amenityModal')).hide());
        window.addEventListener('show-modal', () => new bootstrap.Modal(document.getElementById('amenityModal')).show());
    </script>
</div>