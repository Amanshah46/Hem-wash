<div>
    <!-- Search & Filter Controls -->
    <div class="card radius-16 tw-mb-6">
        <div class="card-body p-24 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center flex-wrap gap-3" style="max-width: 400px; width: 100%;">
                <div class="input-group">
                    <span class="input-group-text bg-base border-neutral-200 text-gray-500">
                        <iconify-icon icon="ion:search-outline"></iconify-icon>
                    </span>
                    <input type="text" class="form-control bg-base border-neutral-200" placeholder="Search Order ID..." wire:model.live="search_query">
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <span class="fw-semibold text-secondary-light text-sm tw-shrink-0">Status:</span>
                <select class="form-select bg-base border-neutral-200 w-auto" wire:model.live="status_filter">
                    <option value="">All Statuses</option>
                    <option value="0">Pending</option>
                    <option value="1">Processing</option>
                    <option value="2">Ready to Deliver</option>
                    <option value="3">Delivered</option>
                    <option value="4">Returned</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card radius-16">
        <div class="card-body p-24">
            @if (session()->has('success_order'))
                <div class="alert alert-success alert-dismissible fade show tw-mb-6" role="alert">
                    {{ session('success_order') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Expected Delivery</th>
                            <th scope="col">Order Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $item)
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
                                <td class="text-primary fw-semibold">
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
                                <td colspan="6" class="text-center text-secondary py-5">
                                    <iconify-icon icon="solar:clipboard-list-outline" class="tw-text-5xl tw-text-gray-300 tw-mb-2"></iconify-icon>
                                    <p class="mb-0">No orders matching the criteria found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-24 d-flex justify-content-end">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
