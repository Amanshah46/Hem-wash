<div class="dashboard-main-body">
    <div class="row gy-4">
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header tw-py-3 tw-px-4 bg-base d-flex align-items-center justify-content-between">
                    <h6 class="card-title mb-0">{{ $lang->data['services'] ?? 'Services' }}</h6>
                    <input type="text" class="form-control form-control-sm w-auto" placeholder="{{ $lang->data['search'] ?? 'Search' }}" wire:model.live="search_query">
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @foreach($services as $item)
                        <div class="col-md-3 col-6">
                            <div class="tw-p-2 tw-border tw-rounded-lg tw-text-center hover:tw-bg-primary-50 tw-cursor-pointer" data-bs-toggle="modal" data-bs-target="#serviceModal" wire:click="selectService({{ $item->id }})">
                                <img src="{{ asset($item->service_image ?? 'assets/images/laundry_icon.png') }}" class="tw-w-12 tw-h-12 tw-mx-auto tw-mb-2 tw-object-contain">
                                <div class="tw-text-xs tw-font-medium">{{ $item->service_name }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header tw-py-3 tw-px-4 bg-base">
                    <h6 class="card-title mb-0">{{ $lang->data['order_summary'] ?? 'Order Summary' }}</h6>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr class="tw-text-xs">
                                    <th>{{ $lang->data['item'] ?? 'Item' }}</th>
                                    <th>{{ $lang->data['qty'] ?? 'Qty' }}</th>
                                    <th>{{ $lang->data['price'] ?? 'Price' }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selservices as $key => $value)
                                <tr class="tw-text-xs">
                                    <td>
                                        @php
                                            $s = \App\Models\Service::find($value['service']);
                                            $st = \App\Models\ServiceType::find($value['service_type']);
                                            $cl = isset($value['cloth']) ? \App\Models\Cloth::find($value['cloth']) : null;
                                        @endphp
                                        <div class="tw-font-medium">{{ $s->service_name }} ({{ $st->service_type_name }})</div>
                                        @if($cl)
                                            <div class="text-muted tw-text-[10px]">Cloth: {{ $cl->cloth_name }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <button class="btn btn-xs btn-outline-secondary" wire:click="decrease({{ $key }})">-</button>
                                            {{ $quantity[$key] }}
                                            <button class="btn btn-xs btn-outline-secondary" wire:click="increase({{ $key }})">+</button>
                                        </div>
                                    </td>
                                    <td>{{ getFormattedCurrency($selling_price[$key] * $quantity[$key]) }}</td>
                                    <td>
                                        <button class="text-danger" wire:click="removeItem({{ $key }})">
                                            <iconify-icon icon="fluent:delete-24-regular"></iconify-icon>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="tw-text-sm">
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $lang->data['sub_total'] ?? 'Sub Total' }}</span>
                            <span>{{ getFormattedCurrency($sub_total) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $lang->data['tax'] ?? 'Tax' }}</span>
                            <span>{{ getFormattedCurrency($tax) }}</span>
                        </div>
                        <div class="d-flex justify-content-between tw-font-bold">
                            <span>{{ $lang->data['total'] ?? 'Total' }}</span>
                            <span>{{ getFormattedCurrency($total) }}</span>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 mt-4" wire:click="save">{{ $lang->data['place_order'] ?? 'Place Order' }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $service->service_name ?? '' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        @foreach($service_types as $type)
                        <div class="col-12 tw-border tw-p-3 tw-rounded-lg tw-mb-2">
                            <div class="form-check tw-mb-2">
                                <input class="form-check-input" type="checkbox" wire:model="selected_type.{{ $type['id'] }}" id="type{{ $type['id'] }}">
                                <label class="form-check-label d-flex justify-content-between w-100" for="type{{ $type['id'] }}">
                                    <span class="tw-font-bold">{{ $type['service_type_name'] }}</span>
                                    <span class="tw-font-bold text-primary">{{ getFormattedCurrency($type['price']) }}</span>
                                </label>
                            </div>
                            <div class="tw-ml-6">
                                <label class="tw-text-xs tw-mb-1 d-block">Select Cloth Type</label>
                                <select class="form-select form-select-sm" wire:model="selected_cloth.{{ $type['id'] }}">
                                    <option value="">Choose Cloth...</option>
                                    @foreach($clothes as $cloth)
                                        <option value="{{ $cloth->id }}">{{ $cloth->cloth_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" wire:click="addItem">{{ $lang->data['add'] ?? 'Add' }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
