<?php

namespace App\Livewire\Installer;

use Livewire\Attributes\Layout;
use Livewire\Component;

class LicenseExpired extends Component
{
    #[Layout('components.layouts.install-layout')]
    public function render()
    {
        return view('livewire.installer.license-expired');
    }
}
