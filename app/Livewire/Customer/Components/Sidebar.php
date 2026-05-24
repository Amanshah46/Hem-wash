<?php

namespace App\Livewire\Customer\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Translation;

class Sidebar extends Component
{
    public $lang;

    public function render()
    {
        return view('livewire.customer.components.sidebar');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        Session::flush();
        return redirect()->route('customer.login');
    }

    public function mount()
    {
        if (session()->has('selected_language')) {
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $this->lang = Translation::where('default', 1)->first();
        }
    }
}
