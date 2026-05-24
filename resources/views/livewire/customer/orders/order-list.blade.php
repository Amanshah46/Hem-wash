<div class="dashboard-main-body">
    <div class="card h-100 p-0">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <form class="navbar-search">
                    <input type="text" class="bg-base tw-px-3 tw-py-1.5 w-auto" name="search" placeholder="{{ $lang->data['search_here'] ?? 'Search Here' }}" wire:model.live="search_query">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
            </div>
            <a href="{{route('customer.order.create')}}" type="button" class="btn btn-primary text-sm btn-sm radius-8 d-flex align-items-center gap-2" >
                <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                {{ $lang->data['add_new_order'] ?? 'Add New Order' }}
            </a>
        </div>
        <div class="tw-p-0">
            <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                  <thead>
                    <tr>
                      <th scope="col" class="">{{ $lang->data['order_info'] ?? 'Order Info' }}</th>
                      <th scope="col" class="">{{ $lang->data['order_amount'] ?? 'Order Amount' }}</th>
                      <th scope="col" class=""> {{ $lang->data['status'] ?? 'Status' }}</th>
                      <th scope="col" class="">{{ $lang->data['payment'] ?? 'Payment' }}</th>
                      <th scope="col" class="text-center">{{ $lang->data['action'] ?? 'Action' }}</th>
                    </tr>
                  </thead>
                  <tbody>
                        @foreach ($orders as $item)
                        <tr class="tw-text-xs">
                            <td>
                                <div class="tw-flex tw-flex-col">
                                    <div class="text-neutral-600">
                                        {{ $lang->data['order_id'] ?? 'Order ID' }} : <span class="tw-font-medium text-primary-light">{{ $item->order_number }}</span>
                                    </div>
                                    <div class="text-neutral-600">
                                        {{ $lang->data['order_date'] ?? 'Order Date' }} : <span class="tw-font-medium text-primary-light">{{ \Carbon\Carbon::parse($item->order_date)->format('d/m/y') }}</span>
                                    </div>
                                    <div class="text-neutral-600">
                                        {{ $lang->data['delivery_date'] ?? 'Delivery Date' }} : <span class="tw-font-medium text-primary-light">{{ \Carbon\Carbon::parse($item->delivery_date)->format('d/m/y') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-primary">
                                {{ getFormattedCurrency($item->total) }}
                            </td>
                            <td class="">
                                @if ($item->status == 0)
                                <span class="badge  fw-semibold text-neutral-600 bg-neutral-200 px-20 py-9 radius-4 text-white">
                                    {{ $lang->data['pending'] ?? 'Pending' }}
                                </span>
                                @elseif($item->status == 1)
                                <span class="badge  fw-semibold text-warning-600 bg-warning-100 px-20 py-9 radius-4 text-white">
                                    {{ $lang->data['processing'] ?? 'Processing' }}
                                </span>
                                @elseif($item->status == 2)
                                <span class="badge  fw-semibold text-info-600 bg-info-100 px-20 py-9 radius-4 text-white">
                                    {{ $lang->data['ready_to_deliver'] ?? 'Ready To Deliver' }}
                                </span>
                                @elseif($item->status == 3)
                                <span class="badge  fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4 text-white">
                                    {{ $lang->data['delivered'] ?? 'Delivered' }}
                                </span>
                                @elseif($item->status == 4)
                                <span class="badge  fw-semibold text-danger-600 bg-danger-100 px-20 py-9 radius-4 text-white">
                                    {{ $lang->data['returned'] ?? 'Returned' }}
                                </span>
                                @endif
                            </td>
                            <td>
                                @php
                                $paidamount = \App\Models\Payment::where('order_id', $item->id)->sum('received_amount');
                                @endphp
                                <div class="tw-flex tw-flex-col">
                                    <div class="text-neutral-600">
                                        {{ $lang->data['total_amount'] ?? 'Total Amount' }} : <span class="tw-font-medium text-primary-light">{{ getFormattedCurrency($item->total) }}</span>
                                    </div>
                                    <div class="text-neutral-600">
                                        {{ $lang->data['paid_amount'] ?? 'Paid Amount' }} : <span class="tw-font-medium text-primary-light"> {{ getFormattedCurrency($paidamount) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                    <a href="{{route('customer.order.view',$item->id)}}" type="button" class="bg-success-100 text-success-600 bg-hover-success-200 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle" >
                                        <iconify-icon icon="lucide:eye" class="menu-icon"></iconify-icon>
                                    </a>
                                    <a href="{{route('customer.order.print',$item->id)}}" target="_blank" class="bg-warning-100 text-warning-600 bg-hover-warning-200 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle" >
                                        <iconify-icon icon="material-symbols-light:print-outline" class="menu-icon tw-text-xl"></iconify-icon>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                  </tbody>
                </table>
                @if(count($orders) == 0)
                    <x-empty-item/>
                @endif
                @if($hasMorePages)
                <div class="text-center pb-2 d-flex justify-content-center align-items-center">
                    <button wire:click="loadOrders" class="btn btn-primary btn-sm">Load More</button>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
