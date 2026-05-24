<?php

namespace App\Livewire\Customer\Components;

use Livewire\Component;
use App\Models\Translation;

class Navbar extends Component
{
    public $title, $lang;

    public function render()
    {
        return view('livewire.customer.components.navbar');
    }

    public function mount($title = null)
    {
        $this->title = $title;
        if (session()->has('selected_language')) {
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $this->lang = Translation::where('default', 1)->first();
        }
    }
}
