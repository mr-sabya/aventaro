@extends('backend.layouts.app')
@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Online Payment: SSLCommerz</h3>
    @if(session('message'))<div class="alert alert-success">{{ session('message') }}</div>@endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Your SSLCommerz keys</h4>
                    @if($gateway->isReady())
                        <span class="badge bg-success">Active: {{ $gateway->is_sandbox ? 'test mode' : 'live' }}</span>
                    @else
                        <span class="badge bg-secondary">Off</span>
                    @endif
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.payments.update') }}" class="row g-3" autocomplete="off">
                        @csrf @method('PUT')

                        <div class="col-md-6">
                            <label class="form-label">Store ID</label>
                            <input name="store_id" value="{{ old('store_id') }}" class="form-control @error('store_id') is-invalid @enderror"
                                   placeholder="{{ $gateway->store_id ? 'Saved ('.\Illuminate\Support\Str::mask($gateway->store_id, '*', 2).'). Leave blank to keep it.' : 'e.g. mystore123' }}">
                            @error('store_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Store Password</label>
                            <input type="password" name="store_password" class="form-control" autocomplete="new-password"
                                   placeholder="{{ $gateway->store_password ? 'Saved. Leave blank to keep it.' : 'Store password / API secret' }}">
                            <div class="form-text">Kept encrypted. It is never shown again.</div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Mode</label>
                            <select name="mode" class="form-select">
                                <option value="sandbox" @selected($gateway->is_sandbox)>Test (sandbox)</option>
                                <option value="live" @selected(! $gateway->is_sandbox)>Live</option>
                            </select>
                            <div class="form-text">Use test keys with Test, real keys with Live.</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Charge in currency</label>
                            <input name="currency" maxlength="3" value="{{ old('currency', $gateway->currency) }}" class="form-control @error('currency') is-invalid @enderror" required>
                            @error('currency')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Rate (1 price unit = ? currency)</label>
                            <input name="rate" type="number" step="0.0001" min="0.0001" value="{{ old('rate', $gateway->rate) }}" class="form-control @error('rate') is-invalid @enderror" required>
                            @error('rate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Tour prices are stored in USD. Use 1 to charge in USD, or e.g. 120 to charge BDT.</div>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $gateway->is_active))>
                                <label class="form-check-label" for="is_active">Offer "Pay online with SSLCommerz" at checkout</label>
                            </div>
                        </div>

                        <div class="col-12"><button class="btn btn-primary">Save</button></div>
                    </form>
                </div>
            </div>

            @if($gateway->hasKeys())
                <form method="POST" action="{{ route('admin.payments.forget') }}" onsubmit="return confirm('Remove the saved keys and switch online payment off?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm">Remove saved keys</button>
                </form>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><h4 class="mb-0">Set up in SSLCommerz</h4></div>
                <div class="card-body small">
                    <p>Get the Store ID and Store Password from your SSLCommerz merchant panel (a free sandbox account works for testing).</p>
                    <p>In the merchant panel, set the IPN (notification) address to:</p>
                    <code class="d-block mb-3">{{ route('payment.sslcommerz.ipn') }}</code>
                    <p class="mb-0">Customers return to this site after paying. A booking is marked paid only after the server asks SSLCommerz to confirm the payment and the amount matches.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
