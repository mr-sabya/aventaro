<div class="container-fluid">
    <div class="card"><div class="card-header"><h4>Tour Review Moderation</h4></div><div class="card-body">
        @if(session('message'))<div class="alert alert-success">{{ session('message') }}</div>@endif
        <div class="row g-3 mb-4"><div class="col-md-8"><input class="form-control" wire:model.live.debounce.300ms="search" placeholder="Search reviewer, email, or tour"></div><div class="col-md-4"><select class="form-select" wire:model.live="status"><option value="pending">Pending</option><option value="approved">Approved</option><option value="all">All</option></select></div></div>
        <div class="table-responsive"><table class="table align-middle"><thead><tr><th>Tour</th><th>Reviewer</th><th>Rating</th><th>Comment</th><th>Status</th><th>Actions</th></tr></thead><tbody>
            @forelse($reviews as $review)
                <tr wire:key="review-{{ $review->id }}"><td>{{ $review->tour?->title }}</td><td><strong>{{ $review->name }}</strong><br><small>{{ $review->email }}</small></td><td>{{ $review->rating }}/5</td><td style="max-width:360px">{{ $review->comment }}</td><td><span class="badge {{ $review->is_approved ? 'bg-success' : 'bg-warning' }}">{{ $review->is_approved ? 'Approved' : 'Pending' }}</span></td><td>@if($review->is_approved)<button class="btn btn-sm btn-warning" wire:click="unapprove({{ $review->id }})">Unapprove</button>@else<button class="btn btn-sm btn-success" wire:click="approve({{ $review->id }})">Approve</button>@endif <button class="btn btn-sm btn-danger" wire:click="delete({{ $review->id }})" wire:confirm="Delete this review?">Delete</button></td></tr>
            @empty<tr><td colspan="6" class="text-center py-4">No reviews found.</td></tr>@endforelse
        </tbody></table></div>{{ $reviews->links() }}
    </div></div>
</div>
