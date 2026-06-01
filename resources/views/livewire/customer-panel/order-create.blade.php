<div>
    <style>
        /* ── Service pill buttons ── */
        .svc-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            min-height: 90px;
            padding: 12px 8px;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            background: #f9fafb;
            color: #374151;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .svc-btn:hover {
            border-color: var(--laundry-primary, #2a5298);
            background: var(--primary-50, #eff6ff);
            color: var(--laundry-primary-active, #1e3c72);
        }
        .svc-btn.active {
            border-color: var(--laundry-primary, #2a5298);
            background: var(--customer-sidebar-gradient, linear-gradient(135deg, #1e3c72, #2a5298));
            color: #fff;
            box-shadow: 0 4px 12px rgba(30,60,114,0.3);
        }
        /* ── Addon toggle buttons ── */
        .addon-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            background: #f9fafb;
            color: #374151;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            width: 100%;
            text-align: left;
        }
        .addon-btn:hover {
            border-color: #22c55e;
            background: #f0fdf4;
        }
        .addon-btn.active {
            border-color: #16a34a;
            background: #dcfce7;
            color: #166534;
        }
        /* ── Summary rows ── */
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            font-size: 14px;
            color: #6b7280;
        }
        .summary-row.total-row {
            font-weight: 700;
            font-size: 16px;
            color: #111827;
            padding-top: 10px;
        }
        /* ── Config panel ── */
        .config-panel {
            margin-top: 20px;
            padding: 16px 20px;
            border-radius: 12px;
            border: 1px solid var(--primary-100, #bfdbfe);
            background: var(--primary-50, #eff6ff);
        }
        /* ── Cart table ── */
        .cart-table { width: 100%; border-collapse: collapse; }
        .cart-table th {
            background: #f3f4f6;
            padding: 10px 12px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .cart-table td {
            padding: 10px 12px;
            font-size: 13px;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
        }
        .qty-btn {
            width: 26px; height: 26px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
            color: #374151;
        }
        .qty-btn:hover { background: #f3f4f6; }
        .del-btn {
            width: 30px; height: 30px;
            border-radius: 6px;
            border: 1px solid #fca5a5;
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #dc2626;
        }
        .del-btn:hover { background: #fef2f2; }
        .submit-btn {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            border: none;
            background: var(--customer-sidebar-gradient, linear-gradient(135deg, #1e3c72, #2a5298));
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: opacity 0.2s;
        }
        .submit-btn:hover { opacity: 0.92; }
    </style>

    <div class="row gy-4">

        {{-- ══════════════ LEFT COLUMN ══════════════ --}}
        <div class="col-lg-8">

            {{-- Step 1: Select Service --}}
            <div class="card radius-16 mb-4" style="border:1px solid #e5e7eb;">
                <div class="card-header py-3 px-4" style="background:#f9fafb; border-bottom:1px solid #e5e7eb; border-radius:16px 16px 0 0;">
                    <h6 class="mb-0 fw-bold" style="color:#111827;">
                        <span style="background: var(--customer-sidebar-gradient, linear-gradient(135deg,#1e3c72,#2a5298)); color:#fff; border-radius:50%; width:24px; height:24px; display:inline-flex; align-items:center; justify-content:center; font-size:12px; margin-right:8px;">1</span>
                        Select Laundry Service
                    </h6>
                </div>
                <div class="card-body p-4">
                    @if($services->isEmpty())
                        <p class="text-center text-muted py-3">No services available.</p>
                    @else
                        <div class="row g-3">
                            @foreach ($services as $service)
                                <div class="col-md-3 col-6">
                                    <button type="button"
                                            wire:click="selectService({{ $service->id }})"
                                            class="svc-btn {{ $selected_service_id == $service->id ? 'active' : '' }}">
                                        <iconify-icon icon="solar:washing-machine-outline" style="font-size:28px;"></iconify-icon>
                                        <span>{{ $service->service_name }}</span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Configuration panel: shown after picking a service --}}
                    @if ($selected_service)
                        <div class="config-panel">
                            <p class="fw-bold mb-3" style="color: var(--laundry-primary-active, #1e3c72); font-size:13px;">
                                Configure: {{ $selected_service->service_name }}
                            </p>
                            <div class="row gy-3 align-items-end">
                                {{-- Service Type --}}
                                <div class="col-md-6 col-12">
                                    <label class="form-label fw-semibold" style="font-size:12px; color:#6b7280;">
                                        Service Action Type <span style="color:#dc2626">*</span>
                                    </label>
                                    <select class="form-select form-select-sm" wire:model="selected_type_id"
                                            style="border-radius:8px; border:1px solid #d1d5db; font-size:13px; padding:8px 12px;">
                                        @foreach ($service_types as $type)
                                            <option value="{{ $type['id'] }}">
                                                {{ $type['name'] }} — {{ getFormattedCurrency($type['price']) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Quantity --}}
                                <div class="col-md-3 col-6">
                                    <label class="form-label fw-semibold" style="font-size:12px; color:#6b7280;">Quantity</label>
                                    <input type="number" class="form-control form-control-sm" min="1"
                                           wire:model="item_qty"
                                           style="border-radius:8px; border:1px solid #d1d5db; font-size:13px; padding:8px 12px;">
                                </div>
                                {{-- Add Button --}}
                                <div class="col-md-3 col-6">
                                    <button type="button" wire:click="addItem"
                                            style="width:100%; height:38px; border-radius:8px; border:none;
                                                   background: var(--customer-sidebar-gradient, linear-gradient(135deg,#1e3c72,#2a5298)); color:#fff;
                                                   font-weight:700; font-size:13px; display:flex; align-items:center;
                                                   justify-content:center; gap:4px; cursor:pointer;">
                                        <iconify-icon icon="ic:baseline-plus" style="font-size:16px;"></iconify-icon>
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Step 2: Cart --}}
            <div class="card radius-16" style="border:1px solid #e5e7eb;">
                <div class="card-header py-3 px-4" style="background:#f9fafb; border-bottom:1px solid #e5e7eb; border-radius:16px 16px 0 0;">
                    <h6 class="mb-0 fw-bold" style="color:#111827;">
                        <span style="background: var(--customer-sidebar-gradient, linear-gradient(135deg,#1e3c72,#2a5298)); color:#fff; border-radius:50%; width:24px; height:24px; display:inline-flex; align-items:center; justify-content:center; font-size:12px; margin-right:8px;">2</span>
                        Order Items Cart
                        @if(count($selservices) > 0)
                            <span style="background:#dcfce7; color:#166534; font-size:11px; padding:2px 8px; border-radius:20px; margin-left:8px;">
                                {{ count($selservices) }} item(s)
                            </span>
                        @endif
                    </h6>
                </div>
                <div class="card-body p-4">
                    @if(count($selservices) === 0)
                        <div class="text-center py-5" style="color:#9ca3af;">
                            <iconify-icon icon="solar:cart-large-minimalistic-outline" style="font-size:48px; color:#d1d5db; display:block; margin-bottom:8px;"></iconify-icon>
                            <p class="mb-0" style="font-size:14px;">Your cart is empty. Select a service above to add items.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="cart-table">
                                <thead>
                                    <tr>
                                        <th>Service Item</th>
                                        <th style="text-align:center;">Qty</th>
                                        <th>Rate</th>
                                        <th>Total</th>
                                        <th style="text-align:center;">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($selservices as $key => $val)
                                        @php
                                            $svc = \App\Models\Service::find($val['service']);
                                            $stype = \App\Models\ServiceType::find($val['service_type']);
                                        @endphp
                                        <tr>
                                            <td>
                                                <div>
                                                    <div class="fw-semibold" style="color:#111827;">{{ $svc->service_name ?? 'N/A' }}</div>
                                                    <div style="font-size:11px; color:#9ca3af;">[{{ $stype->service_type_name ?? '' }}]</div>
                                                </div>
                                            </td>

                                            <td style="text-align:center;">
                                                <div style="display:inline-flex; align-items:center; gap:6px;">
                                                    <button type="button" class="qty-btn" wire:click="decreaseQty({{ $key }})">−</button>
                                                    <span style="font-weight:700; min-width:20px; text-align:center;">{{ $quantity[$key] }}</span>
                                                    <button type="button" class="qty-btn" wire:click="increaseQty({{ $key }})">+</button>
                                                </div>
                                            </td>
                                            <td style="color: var(--laundry-primary); font-weight:600;">{{ getFormattedCurrency($selling_price[$key]) }}</td>
                                            <td style="color: var(--laundry-primary); font-weight:700;">{{ getFormattedCurrency($selling_price[$key] * $quantity[$key]) }}</td>
                                            <td style="text-align:center;">
                                                <button type="button" class="del-btn" wire:click="removeItem({{ $key }})">
                                                    <iconify-icon icon="fluent:delete-24-regular" style="font-size:15px;"></iconify-icon>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>{{-- /col-lg-8 --}}

        {{-- ══════════════ RIGHT COLUMN ══════════════ --}}
        <div class="col-lg-4">

            {{-- Step 3: Addons --}}
            <div class="card radius-16 mb-4" style="border:1px solid #e5e7eb;">
                <div class="card-header py-3 px-4" style="background:#f9fafb; border-bottom:1px solid #e5e7eb; border-radius:16px 16px 0 0;">
                    <h6 class="mb-0 fw-bold" style="color:#111827;">
                        <span style="background: var(--customer-sidebar-gradient, linear-gradient(135deg,#1e3c72,#2a5298)); color:#fff; border-radius:50%; width:24px; height:24px; display:inline-flex; align-items:center; justify-content:center; font-size:12px; margin-right:8px;">3</span>
                        Select Addons
                        <span style="font-size:11px; color:#9ca3af; font-weight:400;">(optional)</span>
                    </h6>
                </div>
                <div class="card-body p-4">
                    @if($addons->isEmpty())
                        <p class="text-center text-muted py-2" style="font-size:13px;">No addons available.</p>
                    @else
                        <div style="display:flex; flex-direction:column; gap:10px;">
                            @foreach ($addons as $addon)
                                <button type="button"
                                        wire:click="toggleAddon({{ $addon->id }})"
                                        class="addon-btn {{ ($selected_addons[$addon->id] ?? false) ? 'active' : '' }}">
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <iconify-icon icon="tabler:puzzle" style="font-size:16px;"></iconify-icon>
                                        <span>{{ $addon->addon_name }}</span>
                                    </div>
                                    <span>{{ getFormattedCurrency($addon->addon_price) }}</span>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Step 4: Order Summary --}}
            <div class="card radius-16" style="border:1px solid #e5e7eb;">
                <div class="card-header py-3 px-4" style="background:#f9fafb; border-bottom:1px solid #e5e7eb; border-radius:16px 16px 0 0;">
                    <h6 class="mb-0 fw-bold" style="color:#111827;">
                        <span style="background: var(--customer-sidebar-gradient, linear-gradient(135deg,#1e3c72,#2a5298)); color:#fff; border-radius:50%; width:24px; height:24px; display:inline-flex; align-items:center; justify-content:center; font-size:12px; margin-right:8px;">4</span>
                        Order Summary
                    </h6>
                </div>
                <div class="card-body p-4">
                    {{-- Totals --}}
                    <div style="display:flex; flex-direction:column; gap:4px; margin-bottom:16px;">
                        <div class="summary-row">
                            <span>Sub Total</span>
                            <span style="font-weight:600; color:#111827;">{{ getFormattedCurrency($sub_total) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Addons Total</span>
                            <span style="font-weight:600; color:#111827;">{{ getFormattedCurrency($addon_total) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax ({{ $tax_percent }}%)</span>
                            <span style="font-weight:600; color:#111827;">{{ getFormattedCurrency($tax) }}</span>
                        </div>
                        <hr style="margin:8px 0; border-color:#e5e7eb;">
                        <div class="summary-row total-row">
                            <span>Grand Total</span>
                            <span style="color: var(--laundry-primary-active, #1e3c72); font-size:18px;">{{ getFormattedCurrency($total) }}</span>
                        </div>
                    </div>

                    {{-- Delivery Date --}}
                    <div style="margin-bottom:12px;">
                        <label class="form-label fw-semibold" style="font-size:12px; color:#6b7280;">
                            Expected Delivery Date <span style="color:#dc2626;">*</span>
                        </label>
                        <input type="date" class="form-control form-control-sm" wire:model="delivery_date"
                               style="border-radius:8px; border:1px solid #d1d5db; font-size:13px; padding:8px 12px;">
                    </div>

                    {{-- Notes --}}
                    <div style="margin-bottom:20px;">
                        <label class="form-label fw-semibold" style="font-size:12px; color:#6b7280;">
                            Notes / Instructions
                        </label>
                        <textarea class="form-control form-control-sm" rows="3" wire:model="notes"
                                  placeholder="Enter special instructions..."
                                  style="border-radius:8px; border:1px solid #d1d5db; font-size:13px; padding:8px 12px; resize:vertical;"></textarea>
                    </div>

                    {{-- Submit --}}
                    <button type="button" wire:click="submitOrder" class="submit-btn">
                        <iconify-icon icon="solar:bill-list-outline" style="font-size:20px;"></iconify-icon>
                        <span>Submit Order</span>
                        <span wire:loading wire:target="submitOrder"
                              class="spinner-border spinner-border-sm ms-1" role="status"></span>
                    </button>
                </div>
            </div>

        </div>{{-- /col-lg-4 --}}
    </div>
</div>
