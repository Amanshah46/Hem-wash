<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceType;
use App\Models\ServiceDetail;
use App\Models\Cloth;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample clothes
        $clothes = ['Shirt', 'Pants', 'Dress', 'Suit', 'Blanket'];
        foreach ($clothes as $name) {
            Cloth::create([
                'cloth_name' => $name,
                'is_active' => 1
            ]);
        }

        // Create sample service types
        $types = [
            ['name' => 'Washing', 'price' => 10],
            ['name' => 'Ironing', 'price' => 5],
            ['name' => 'Dry Clean', 'price' => 20],
        ];

        foreach ($types as $t) {
            $serviceType = ServiceType::create([
                'service_type_name' => $t['name'],
                'is_active' => 1
            ]);

            // Create a service for this type
            $service = Service::create([
                'service_name' => $t['name'],
                'icon' => 'default.png',
                'is_active' => 1
            ]);

            // Link them in service_details
            ServiceDetail::create([
                'service_id' => $service->id,
                'service_type_id' => $serviceType->id,
                'service_price' => $t['price']
            ]);
        }
    }
}
