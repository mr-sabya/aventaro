<?php

namespace App\Livewire\Backend\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{

    public function logout()
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        // Redirect to your admin login page or home page
        return redirect()->route('admin.login');
    }

    public function render()
    {
        return view('livewire.backend.auth.logout');
    }
}
