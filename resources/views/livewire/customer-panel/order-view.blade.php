<div>
    <!-- Back button & tracking header -->
    <div class="d-flex align-items-center justify-content-between tw-mb-6">
        <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary radius-8 py-8 px-16 d-flex align-items-center gap-2">
            <iconify-icon icon="solar:arrow-left-outline" class="tw-text-lg"></iconify-icon>
            <span>Back to Orders</span>
        </a>
        <div class="tw-text-right">
            <span class="text-secondary-light text-xs">Order ID</span>
            <h5 class="mb-0 tw-font-bold text-gray-800">#{{ $order->order_number }}</h5>
        </div>
    </div>

    <!-- Timeline Tracking Section -->
    <div class="card radius-16 tw-mb-6">
        <div class="card-header border-bottom bg-base py-16 px-24">
            <h6 class="mb-0 tw-font-bold text-gray-800">Order Tracking Status</h6>
        </div>
        <div class="card-body p-24">
            @if ($order->status == 4)
                <!-- Returned Status Special Banner -->
                <div class="alert alert-danger d-flex align-items-center gap-3 radius-8 mb-0" role="alert">
                    <iconify-icon icon="solar:info-circle-bold" class="tw-text-2xl"></iconify-icon>
                    <div>
                        <strong class="d-block">Order Returned</strong>
                        <span>This order has been returned. Please contact support if you have any questions.</span>
                    </div>
                </div>
            @else
                <!-- Timeline progress bar -->
                <div class="tw-flex tw-flex-col md:tw-flex-row tw-justify-between tw-items-center tw-relative tw-w-full tw-gap-8 md:tw-gap-0">
                    <!-- Progress Line background -->
                    <div class="tw-absolute tw-left-1/2 md:tw-left-0 tw-top-0 md:tw-top-1/2 tw-h-full md:tw-h-[4px] tw-w-[4px] md:tw-w-full tw-bg-gray-200 -tw-translate-x-1/2 md:-tw-translate-y-1/2 tw-z-0"></div>
                    
                    <!-- Active Progress Line overlay -->
                    @php
                        $progressWidth = '0%';
                        if ($order->status == 1) $progressWidth = '33%';
                        if ($order->status == 2) $progressWidth = '66%';
                        if ($order->status == 3) $progressWidth = '100%';
                    @endphp
                    <div class="tw-absolute tw-left-1/2 md:tw-left-0 tw-top-0 md:tw-top-1/2 tw-h-full md:tw-h-[4px] tw-w-[4px] md:tw-w-full tw-bg-success-500 -tw-translate-x-1/2 md:-tw-translate-y-1/2 tw-z-0 tw-transition-all tw-duration-500 tw-hidden md:tw-block" style="width: {{ $progressWidth }};"></div>

                    <!-- Step 1: Placed -->
                    <div class="tw-flex tw-flex-col tw-items-center tw-z-10 tw-relative">
                        <div class="tw-size-10 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-transition-colors tw-duration-300
                            {{ $order->status >= 0 ? 'tw-bg-success-500 text-white' : 'tw-bg-gray-200 text-gray-400' }}">
                            <iconify-icon icon="solar:checklist-minimalistic-bold" class="tw-text-xl"></iconify-icon>
                        </div>
                        <span class="tw-mt-2 tw-font-semibold tw-text-xs {{ $order->status >= 0 ? 'text-success-600' : 'text-gray-500' }}">Order Placed</span>
                        <span class="text-secondary-light text-xxs mt-1">{{ \Carbon\Carbon::parse($order->order_date)->format('d M, h:i A') }}</span>
                    </div>

                    <!-- Step 2: Processing -->
                    <div class="tw-flex tw-flex-col tw-items-center tw-z-10 tw-relative">
                        <div class="tw-size-10 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-transition-colors tw-duration-300
                            {{ $order->status >= 1 ? 'tw-bg-success-500 text-white' : 'tw-bg-gray-200 text-gray-400' }}">
                            <iconify-icon icon="solar:washing-machine-bold" class="tw-text-xl"></iconify-icon>
                        </div>
                        <span class="tw-mt-2 tw-font-semibold tw-text-xs {{ $order->status >= 1 ? 'text-success-600' : 'text-gray-500' }}">Processing</span>
                        <span class="text-secondary-light text-xxs mt-1">
                            {{ $order->status >= 1 ? 'In Progress' : 'Pending' }}
                        </span>
                    </div>

                    <!-- Step 3: Ready to Deliver -->
                    <div class="tw-flex tw-flex-col tw-items-center tw-z-10 tw-relative">
                        <div class="tw-size-10 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-transition-colors tw-duration-300
                            {{ $order->status >= 2 ? 'tw-bg-success-500 text-white' : 'tw-bg-gray-200 text-gray-400' }}">
                            <iconify-icon icon="solar:box-bold" class="tw-text-xl"></iconify-icon>
                        </div>
                        <span class="tw-mt-2 tw-font-semibold tw-text-xs {{ $order->status >= 2 ? 'text-success-600' : 'text-gray-500' }}">Ready for Delivery</span>
                        <span class="text-secondary-light text-xxs mt-1">
                            {{ $order->status >= 2 ? 'Ready' : 'Awaiting Processing' }}
                        </span>
                    </div>

                    <!-- Step 4: Delivered -->
                    <div class="tw-flex tw-flex-col tw-items-center tw-z-10 tw-relative">
                        <div class="tw-size-10 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-transition-colors tw-duration-300
                            {{ $order->status == 3 ? 'tw-bg-success-500 text-white' : 'tw-bg-gray-200 text-gray-400' }}">
                            <iconify-icon icon="solar:home-smile-bold" class="tw-text-xl"></iconify-icon>
                        </div>
                        <span class="tw-mt-2 tw-font-semibold tw-text-xs {{ $order->status == 3 ? 'text-success-600' : 'text-gray-500' }}">Delivered</span>
                        <span class="text-secondary-light text-xxs mt-1">
                            {{ $order->status == 3 ? 'Completed' : 'Awaiting Delivery' }}
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Order Details / Items Grid -->
    <div class="row gy-4">
        <!-- Left: Items & Invoice -->
        <div class="col-lg-8">
            <div class="card radius-16 h-100">
                <div class="card-header border-bottom bg-base py-16 px-24 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="tw-flex tw-flex-col">
                        <span class="tw-font-bold text-gray-800 text-base">{{ $sitename }}</span>
                        <span class="text-secondary-light text-xs">{{ $address }}</span>
                        <span class="text-secondary-light text-xs">Ph: {{ $phone }} | {{ $store_email }}</span>
                    </div>
                    <div class="tw-text-right">
                        <span class="text-secondary-light text-xs">Tax ID: {{ $tax_number }}</span>
                    </div>
                </div>
                <div class="card-body p-24">
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table sm-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Service Item</th>
                                    <th scope="col" class="text-center">Color</th>
                                    <th scope="col">Rate</th>
                                    <th scope="col" class="text-center">QTY</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderdetails as $item)
                                    @php
                                        $service = \App\Models\Service::find($item->service_id);
                                    @endphp
                                    <tr class="tw-text-sm">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="tw-flex tw-gap-3">
                                                @if($service)
                                                    <div class="tw-w-8 tw-h-8">
                                                        <img src="{{ asset('assets/img/service-icons/' . $service->icon) }}" class="tw-w-8 tw-h-8 tw-object-contain" alt="">
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="mb-0 fw-semibold text-gray-800">{{ $service ? $service->service_name : 'Deleted Service' }}</p>
                                                    <span class="text-gray-500 text-xs">[{{ $item->service_name }}]</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($item->color_code)
                                                <div class="d-inline-block tw-w-6 tw-h-6 tw-rounded border" style="background-color: {{ $item->color_code }}"></div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-primary">
                                            {{ getFormattedCurrency($item->service_price) }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->service_quantity }}
                                        </td>
                                        <td class="text-primary fw-semibold">
                                            {{ getFormattedCurrency($item->service_detail_total) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Payment breakdown & billing summary -->
                    <div class="mt-24 tw-flex tw-flex-col sm:tw-flex-row tw-justify-between tw-gap-4 border-top pt-20">
                        <!-- Invoice details -->
                        <div class="tw-flex tw-flex-col">
                            <span class="text-secondary-light text-xs">Order Notes</span>
                            <p class="text-gray-600 mt-1 mb-0">{{ $order->note ? $order->note : 'No custom instructions provided.' }}</p>
                        </div>
                        
                        <!-- Cost Summary -->
                        <div class="tw-w-[18rem] tw-shrink-0">
                            <div class="d-flex justify-content-between text-secondary mb-2">
                                <span>Sub Total</span>
                                <span>{{ getFormattedCurrency($order->sub_total) }}</span>
                            </div>
                            <div class="d-flex justify-content-between text-secondary mb-2">
                                <span>Addons Total</span>
                                <span>{{ getFormattedCurrency($order->addon_total) }}</span>
                            </div>
                            <div class="d-flex justify-content-between text-secondary mb-2">
                                <span>Tax ({{ $order->tax_percentage }}%)</span>
                                <span>{{ getFormattedCurrency($order->tax_amount) }}</span>
                            </div>
                            @if ($order->discount > 0)
                                <div class="d-flex justify-content-between text-danger mb-2">
                                    <span>Discount</span>
                                    <span>-{{ getFormattedCurrency($order->discount) }}</span>
                                </div>
                            @endif
                            <hr class="my-2">
                            <div class="d-flex justify-content-between text-gray-800 fw-bold text-base">
                                <span>Grand Total</span>
                                <span>{{ getFormattedCurrency($order->total) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Addons & Payment Status -->
        <div class="col-lg-4">
            <!-- Service Addons Details -->
            @if (count($orderaddons) > 0)
                <div class="card radius-16 tw-mb-6">
                    <div class="card-header border-bottom bg-base py-16 px-24">
                        <h6 class="mb-0 tw-font-bold text-gray-800">Selected Addons</h6>
                    </div>
                    <div class="card-body p-24">
                        <div class="tw-flex tw-flex-col tw-gap-3">
                            @foreach ($orderaddons as $item)
                                <div class="p-12 radius-10 border border-neutral-200 bg-neutral-50 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <iconify-icon icon="tabler:puzzle" class="tw-text-lg text-secondary"></iconify-icon>
                                        <span class="fw-semibold text-xs text-gray-800">{{ $item->addon_name }}</span>
                                    </div>
                                    <span class="fw-bold text-xs text-primary">{{ getFormattedCurrency($item->addon_price) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Ledger/Payments Info -->
            <div class="card radius-16">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="mb-0 tw-font-bold text-gray-800">Payment Summary</h6>
                </div>
                <div class="card-body p-24">
                    <div class="tw-flex tw-flex-col tw-gap-3">
                        <div class="d-flex justify-content-between text-secondary">
                            <span>Invoiced Amount</span>
                            <span>{{ getFormattedCurrency($order->total) }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-success">
                            <span>Paid Amount</span>
                            <span>{{ getFormattedCurrency($paid_amount) }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between text-danger fw-bold">
                            <span>Outstanding Balance</span>
                            <span>{{ getFormattedCurrency($balance) }}</span>
                        </div>
                    </div>

                    @if (count($payments) > 0)
                        <div class="mt-24 border-top pt-20">
                            <span class="fw-semibold text-gray-800 text-xs d-block mb-12">Transaction History</span>
                            @foreach ($payments as $pay)
                                <div class="tw-flex tw-items-start tw-gap-3 tw-mb-3 text-xs">
                                    <div class="text-success mt-1">
                                        <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                                    </div>
                                    <div>
                                        <span class="d-block fw-bold text-gray-800">{{ getFormattedCurrency($pay->received_amount) }}</span>
                                        <span class="text-secondary-light">
                                            {{ \Carbon\Carbon::parse($pay->payment_date)->format('d M, Y') }} 
                                            [{{ getpaymentMode($pay->payment_type) }}]
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
