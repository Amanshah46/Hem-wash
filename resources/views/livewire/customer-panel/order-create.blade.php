<div>
    <div class="row gy-4">
        <!-- Left: Service Selector & Cart -->
        <div class="col-lg-8">
            <!-- Step 1: Select Service -->
            <div class="card radius-16 tw-mb-6">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="mb-0 tw-font-bold text-gray-800">1. Select Laundry Service</h6>
                </div>
                <div class="card-body p-24">
                    <div class="row g-3">
                        @foreach ($services as $service)
                            <div class="col-md-3 col-6">
                                <button type="button" wire:click="selectService({{ $service->id }})" 
                                    class="w-100 p-16 radius-12 border text-center tw-transition-all d-flex flex-column align-items-center justify-content-center gap-2
                                    {{ $selected_service_id == $service->id ? 'bg-primary text-white border-primary shadow' : 'bg-neutral-50 text-secondary border-neutral-200 bg-hover-neutral-100' }}">
                                    
                                    <div class="tw-w-12 tw-h-12 tw-rounded-full bg-white/20 tw-flex tw-items-center tw-justify-center">
                                        <img src="{{ asset('assets/img/service-icons/' . $service->icon) }}" class="tw-w-8 tw-h-8 tw-object-contain" alt="">
                                    </div>
                                    <span class="fw-semibold text-sm">{{ $service->service_name }}</span>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <!-- Step 1.1: Select Service Type & Details -->
                    @if ($selected_service)
                        <div class="mt-24 p-20 radius-12 border border-primary-100 bg-primary-50/20">
                            <h6 class="text-primary fw-bold text-sm mb-16">Configure: {{ $selected_service->service_name }}</h6>
                            <div class="row gy-3 align-items-end">
                                <!-- Type Selection -->
                                <div class="col-md-5">
                                    <label class="form-label fw-semibold text-secondary text-xs">Service Action Type *</label>
                                    <select class="form-select bg-base radius-8" wire:model="selected_type_id">
                                        @foreach ($service_types as $type)
                                            <option value="{{ $type['id'] }}">{{ $type['name'] }} - {{ getFormattedCurrency($type['price']) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Quantity -->
                                <div class="col-md-3 col-6">
                                    <label class="form-label fw-semibold text-secondary text-xs">Quantity</label>
                                    <input type="number" class="form-control radius-8 bg-base" min="1" wire:model="item_qty">
                                </div>
                                <!-- Color -->
                                <div class="col-md-2 col-6">
                                    <label class="form-label fw-semibold text-secondary text-xs">Garment Color</label>
                                    <input type="color" class="form-control form-control-color radius-8 w-100 h-40-px bg-base border" wire:model="item_color">
                                </div>
                                <!-- Action Button -->
                                <div class="col-md-2">
                                    <button type="button" wire:click="addItem" class="btn btn-primary radius-8 w-100 h-40-px px-0 d-flex align-items-center justify-content-center gap-1">
                                        <iconify-icon icon="ic:baseline-plus" class="tw-text-lg"></iconify-icon>
                                        <span>Add</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Step 2: Order Cart -->
            <div class="card radius-16">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="mb-0 tw-font-bold text-gray-800">2. Order Items Cart</h6>
                </div>
                <div class="card-body p-24">
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table sm-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Service Item</th>
                                    <th scope="col" class="text-center">Color</th>
                                    <th scope="col" class="text-center">Qty</th>
                                    <th scope="col">Rate</th>
                                    <th scope="col">Total</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($selservices as $key => $val)
                                    @php
                                        $service = \App\Models\Service::find($val['service']);
                                        $type = \App\Models\ServiceType::find($val['service_type']);
                                    @endphp
                                    <tr class="tw-text-xs">
                                        <td>
                                            <div class="tw-flex tw-gap-3">
                                                <div class="tw-w-8 tw-h-8">
                                                    <img src="{{ asset('assets/img/service-icons/' . $service->icon) }}" class="tw-w-8 tw-h-8 tw-object-contain" alt="">
                                                </div>
                                                <div>
                                                    <p class="mb-0 fw-semibold text-gray-800">{{ $service->service_name }}</p>
                                                    <span class="text-gray-500 text-xs">[{{ $type->service_type_name }}]</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-block tw-w-6 tw-h-6 tw-rounded border" style="background-color: {{ $colors[$key] }}"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <button type="button" wire:click="decreaseQty({{ $key }})" class="btn btn-sm btn-outline-secondary p-1 tw-size-6 d-flex align-items-center justify-content-center radius-4">
                                                    <iconify-icon icon="ic:baseline-minus"></iconify-icon>
                                                </button>
                                                <span class="fw-semibold">{{ $quantity[$key] }}</span>
                                                <button type="button" wire:click="increaseQty({{ $key }})" class="btn btn-sm btn-outline-secondary p-1 tw-size-6 d-flex align-items-center justify-content-center radius-4">
                                                    <iconify-icon icon="ic:baseline-plus"></iconify-icon>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="text-primary fw-semibold">
                                            {{ getFormattedCurrency($selling_price[$key]) }}
                                        </td>
                                        <td class="text-primary fw-semibold">
                                            {{ getFormattedCurrency($selling_price[$key] * $quantity[$key]) }}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" wire:click="removeItem({{ $key }})" class="btn btn-sm btn-outline-danger p-1 radius-4">
                                                <iconify-icon icon="fluent:delete-24-regular" class="tw-text-base"></iconify-icon>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-secondary py-4">
                                            <iconify-icon icon="solar:cart-large-minimalistic-outline" class="tw-text-4xl tw-text-gray-300 tw-mb-2"></iconify-icon>
                                            <p class="mb-0">Your order cart is empty.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Checkout Summary -->
        <div class="col-lg-4">
            <!-- Addons Selector -->
            <div class="card radius-16 tw-mb-6">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="mb-0 tw-font-bold text-gray-800">3. Select Addons</h6>
                </div>
                <div class="card-body p-24">
                    <div class="tw-flex tw-flex-col tw-gap-3">
                        @foreach ($addons as $addon)
                            <button type="button" wire:click="toggleAddon({{ $addon->id }})" 
                                class="p-12 radius-10 border text-start tw-transition-all d-flex align-items-center justify-content-between
                                {{ $selected_addons[$addon->id] ?? false ? 'bg-success-50 border-success text-success-800' : 'bg-neutral-50 border-neutral-200 text-secondary' }}">
                                <div class="d-flex align-items-center gap-2">
                                    <iconify-icon icon="tabler:puzzle" class="tw-text-lg"></iconify-icon>
                                    <span class="fw-semibold text-xs">{{ $addon->addon_name }}</span>
                                </div>
                                <span class="fw-bold text-xs">{{ getFormattedCurrency($addon->addon_price) }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Total Checkout details -->
            <div class="card radius-16">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="mb-0 tw-font-bold text-gray-800">4. Order Summary</h6>
                </div>
                <div class="card-body p-24">
                    <div class="tw-flex tw-flex-col tw-gap-3">
                        <!-- Sub Total -->
                        <div class="d-flex justify-content-between text-secondary">
                            <span>Sub Total</span>
                            <span>{{ getFormattedCurrency($sub_total) }}</span>
                        </div>
                        
                        <!-- Addon Cost -->
                        <div class="d-flex justify-content-between text-secondary">
                            <span>Addons Total</span>
                            <span>{{ getFormattedCurrency($addon_total) }}</span>
                        </div>

                        <!-- Tax Cost -->
                        <div class="d-flex justify-content-between text-secondary">
                            <span>Tax ({{ $tax_percent }}%)</span>
                            <span>{{ getFormattedCurrency($tax) }}</span>
                        </div>

                        <hr class="my-2">

                        <!-- Total Cost -->
                        <div class="d-flex justify-content-between text-gray-800 fw-bold text-base">
                            <span>Grand Total</span>
                            <span>{{ getFormattedCurrency($total) }}</span>
                        </div>
                    </div>

                    <!-- Delivery Date & Notes -->
                    <div class="mt-24">
                        <div class="mb-16">
                            <label class="form-label fw-semibold text-gray-700 text-xs">Expected Delivery Date *</label>
                            <input type="date" class="form-control radius-8" wire:model="delivery_date">
                        </div>
                        <div class="mb-20">
                            <label class="form-label fw-semibold text-gray-700 text-xs">Notes/Instructions</label>
                            <textarea class="form-control radius-8" rows="3" placeholder="Enter special instructions..." wire:model="notes"></textarea>
                        </div>
                    </div>

                    <!-- Place Order CTA -->
                    <button type="button" wire:click="submitOrder" class="btn btn-primary w-100 py-12 radius-8 fw-semibold d-flex align-items-center justify-content-center gap-2">
                        <iconify-icon icon="solar:bill-list-outline" class="tw-text-xl"></iconify-icon>
                        <span>Submit Order</span>
                        <div class="spinner-border tw-size-3" role="status" wire:loading wire:target="submitOrder">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
