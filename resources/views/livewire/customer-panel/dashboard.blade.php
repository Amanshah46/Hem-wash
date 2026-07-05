<div>
    <!-- Stats Cards Row -->
  <div class="container-fluid">
    <div class="row g-4">

        <!-- Active Orders -->
        <div class="col-lg-4 col-md-6 col-12">
            <div class="card p-3 radius-12 customer-card-glass"
                 style="border-left:4px solid var(--laundry-primary) !important;">
                <div class="card-body p-0 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-secondary-light fw-medium text-sm">
                            Active Orders
                        </span>
                        <h4 class="mb-0 mt-1 fw-bold text-dark">
                            {{ $active_orders }}
                        </h4>
                    </div>

                    <div class="w-50-px h-50-px radius-8 d-flex justify-content-center align-items-center"
                         style="background-color: var(--primary-50); color: var(--laundry-primary);">
                        <iconify-icon
                            icon="solar:washing-machine-outline"
                            class="fs-3">
                        </iconify-icon>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="col-lg-4 col-md-6 col-12">
            <div class="card p-3 radius-12 customer-card-glass"
                 style="border-left:4px solid #22c55e !important;">
                <div class="card-body p-0 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-secondary-light fw-medium text-sm">
                            Completed Orders
                        </span>
                        <h4 class="mb-0 mt-1 fw-bold text-dark">
                            {{ $completed_orders }}
                        </h4>
                    </div>

                    <div class="w-50-px h-50-px radius-8 d-flex justify-content-center align-items-center"
                         style="background:#ecfdf5;color:#16a34a;">
                        <iconify-icon
                            icon="solar:bill-check-outline"
                            class="fs-3">
                        </iconify-icon>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Spend -->
        <div class="col-lg-4 col-md-6 col-12">
            <div class="card p-3 radius-12 customer-card-glass"
                 style="border-left:4px solid #f59e0b !important;">
                <div class="card-body p-0 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-secondary-light fw-medium text-sm">
                            Total Spend
                        </span>
                        <h4 class="mb-0 mt-1 fw-bold text-dark">
                            {{ getFormattedCurrency($invoice_amount) }}
                        </h4>
                    </div>

                    <div class="w-50-px h-50-px radius-8 d-flex justify-content-center align-items-center"
                         style="background:#fffbeb;color:#d97706;">
                        <iconify-icon
                            icon="solar:wallet-money-outline"
                            class="fs-3">
                        </iconify-icon>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

    <!-- Quick Action / Welcome Banner -->
    <div class="card radius-16 tw-overflow-hidden tw-mt-6 text-white" style="background: var(--customer-sidebar-gradient, linear-gradient(135deg, #1e3c72 0%, #2a5298 100%));">
        <div class="card-body p-24 tw-flex tw-flex-col sm:tw-flex-row tw-items-center tw-justify-between tw-gap-4">
            <div>
                <h4 class="mb-2 text-white tw-font-bold">Need laundry done?</h4>
                <p class="text-white-50 mb-0">Select your items, pick addons, and place a new service order in seconds.</p>
            </div>
            <a href="{{ route('customer.orders.create') }}" class="btn btn-light text-primary fw-semibold px-24 py-12 radius-8 d-flex align-items-center gap-2">
                <iconify-icon icon="solar:cart-large-minimalistic-bold" class="tw-text-lg"></iconify-icon>
                <span>New Laundry Order</span>
            </a>
        </div>
    </div>

    <!-- Recent Orders Section -->
    <div class="card radius-16 mt-24">
        <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
            <h6 class="mb-0 tw-font-bold text-gray-800">Recent Laundry Orders</h6>
            <a href="{{ route('customer.orders') }}" class="text-primary-600 fw-semibold text-sm">View All Orders</a>
        </div>
        <div class="card-body p-24">
            <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Expected Delivery</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recent_orders as $item)
                            <tr class="tw-text-xs">
                                <td>
                                    <span class="tw-font-bold text-primary-light">{{ $item->order_number }}</span>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->order_date)->format('d M, Y') }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->delivery_date)->format('d M, Y') }}
                                </td>
                                <td class="text-primary">
                                    {{ getFormattedCurrency($item->total) }}
                                </td>
                                <td>
                                    @if ($item->status == 0)
                                        <span class="badge fw-semibold text-neutral-600 bg-neutral-100 px-12 py-6 radius-4">
                                            Pending
                                        </span>
                                    @elseif($item->status == 1)
                                        <span class="badge fw-semibold text-warning-600 bg-warning-100 px-12 py-6 radius-4">
                                            Processing
                                        </span>
                                    @elseif($item->status == 2)
                                        <span class="badge fw-semibold text-info-600 bg-info-100 px-12 py-6 radius-4">
                                            Ready to Deliver
                                        </span>
                                    @elseif($item->status == 3)
                                        <span class="badge fw-semibold text-success-600 bg-success-100 px-12 py-6 radius-4">
                                            Delivered
                                        </span>
                                    @elseif($item->status == 4)
                                        <span class="badge fw-semibold text-danger-600 bg-danger-100 px-12 py-6 radius-4">
                                            Returned
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('customer.orders.view', $item->id) }}" class="btn btn-sm btn-outline-primary py-1 px-3 radius-8">
                                        <div class="d-flex align-items-center gap-1">
                                            <iconify-icon icon="solar:eye-outline"></iconify-icon>
                                            <span>Track & View</span>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary py-4">
                                    <iconify-icon icon="solar:clipboard-list-outline" class="tw-text-4xl tw-text-gray-300 tw-mb-2"></iconify-icon>
                                    <p class="mb-0">No orders placed yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
