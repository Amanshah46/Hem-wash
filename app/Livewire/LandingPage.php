<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\ServiceDetail;

class LandingPage extends Component
{
    public function render()
    {
        $services = Service::where('is_active', 1)->get()->map(function ($service) {
            $service->pricing = ServiceDetail::join('service_types', 'service_types.id', '=', 'service_details.service_type_id')
                ->where('service_details.service_id', $service->id)
                ->select('service_types.service_type_name', 'service_details.service_price')
                ->get();
            return $service;
        });

        return view('livewire.landing-page', compact('services'))
            ->layout('components.layouts.landing');
    }
}
