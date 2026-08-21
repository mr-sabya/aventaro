@extends('backend.layouts.app')
@section('content')
<div class="card"><div class="card-header"><h4>Content Pages</h4><small>Edit reusable page, breadcrumb, SEO, and section content.</small></div><div class="card-body"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Page</th><th>URL</th><th>Status</th><th></th></tr></thead><tbody>@foreach($pages as $page)<tr><td><strong>{{ $page->title }}</strong></td><td>/{{ $page->slug }}</td><td><span class="badge {{ $page->is_active?'bg-success':'bg-secondary' }}">{{ $page->is_active?'Active':'Hidden' }}</span></td><td class="text-end"><a class="btn btn-primary btn-sm" href="{{ route('admin.content-pages.edit',$page) }}">Edit</a></td></tr>@endforeach</tbody></table></div></div></div>
@endsection
