<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'currency' => ['nullable', 'string', 'exists:currencies,code'],
            'language' => ['nullable', 'string', 'exists:languages,code'],
        ]);

        if (! empty($data['currency']) && Currency::where('code', $data['currency'])->where('is_active', true)->exists()) {
            $request->session()->put('currency', $data['currency']);
        }
        if (! empty($data['language']) && Language::where('code', $data['language'])->where('is_active', true)->exists()) {
            $request->session()->put('language', $data['language']);
        }

        return back();
    }
}
