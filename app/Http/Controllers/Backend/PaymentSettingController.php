<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    public function edit()
    {
        return view('backend.payments.index', ['gateway' => PaymentGateway::sslcommerz()]);
    }

    public function update(Request $request)
    {
        $gateway = PaymentGateway::sslcommerz();
        $data = $request->validate([
            'store_id' => ['nullable', 'string', 'max:120'],
            'store_password' => ['nullable', 'string', 'max:200'],
            'currency' => ['required', 'string', 'alpha', 'size:3'],
            'rate' => ['required', 'numeric', 'min:0.0001', 'max:100000'],
        ]);

        // Blank keeps what is saved, so the password never has to be shown again.
        foreach (['store_id', 'store_password'] as $field) {
            if (blank($data[$field] ?? null)) {
                unset($data[$field]);
            }
        }
        $data['currency'] = strtoupper($data['currency']);
        $data['is_sandbox'] = $request->input('mode') !== 'live';
        $gateway->fill($data);

        $wantsActive = $request->boolean('is_active');
        if ($wantsActive && ! $gateway->hasKeys()) {
            $gateway->is_active = false;
            $gateway->save();

            return back()->withErrors(['store_id' => 'Add the Store ID and Store Password before switching SSLCommerz on.'])->withInput($request->except('store_password'));
        }
        $gateway->is_active = $wantsActive;
        $gateway->save();

        return back()->with('message', 'Payment settings saved.');
    }

    public function forget()
    {
        PaymentGateway::sslcommerz()->update(['store_id' => null, 'store_password' => null, 'is_active' => false]);

        return back()->with('message', 'SSLCommerz keys removed and online payment switched off.');
    }
}
