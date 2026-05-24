<div class="dashboard-main-body">
    <div class="tw-flex tw-gap-4 lg:tw-flex-row tw-flex-col">
        <div class="card h-100 p-0 radius-12 tw-w-full">
            <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between ">
                <div class="tw-flex tw-flex-col  tw-text-sm">
                    <div class="text-lg tw-font-medium text-primary-light">
                        {{ $sitename }}
                    </div>
                    <div class="tw-flex tw-flex-col tw-mt-2">
                        <div class="">{{$phone ? getCountryCode() : ''}}{{ (int)$phone }}</div>
                        <div class="">{{ $store_email }}</div>
                        <div class="">{{ $address }} - {{ $zipcode }}</div>
                        <div class="tw-mt-2">{{ $lang->data['tax'] ?? 'TAX' }}: {{ $tax_number }}</div>
                    </div>
                </div>
                <div class="tw-flex tw-flex-col  tw-text-sm tw-items-end">
                    <div class="tw-flex tw-flex-col tw-mt-2 tw-items-end">
                        <div class="text-neutral-600">
                            {{ $lang->data['order_id'] ?? 'Order ID' }} : <span class="tw-font-medium text-primary-light">#{{ $order->order_number }}</span>
                        </div>
                        <div class="text-neutral-600">
                            {{ $lang->data['order_date'] ?? 'Order Date' }} : <span class="tw-font-medium text-primary-light">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</span>
                        </div>
                        <div class="text-neutral-600">
                            {{ $lang->data['delivery_date'] ?? 'Delivery Date' }} : <span class="tw-font-medium text-primary-light">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</span>
                        </div>
                        <div class="tw-mt-2 tw-flex tw-items-center tw-gap-2">
                            <div class="">
                                {{ $lang->data['order_status'] ?? 'Order Status' }} :
                            </div>
                            <div class="fw-bold text-primary">
                                {{ getOrderStatus($order->status) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-24">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                      <thead>
                        <tr>
                          <th scope="col" class="">#</th>
                          <th scope="col" class="">{{ $lang->data['service_name'] ?? 'Service Name' }}</th>
                          <th scope="col" class="">{{ $lang->data['rate'] ?? 'Rate' }}</th>
                          <th scope="col" class=""> {{ $lang->data['qty'] ?? 'QTY' }}</th>
                          <th scope="col" class=""> {{ $lang->data['total'] ?? 'Total' }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($orderdetails as $item)
                            @php
                                $service = \App\Models\Service::where('id', $item->service_id)->first();
                            @endphp
                            <tr class="tw-text-sm">
                                <td>{{ $loop->index + 1 }}</td>
                                <td class="">
                                    <div class="tw-flex tw-gap-4">
                                        <div class="tw-flex tw-flex-col">
                                            <p class="tw-text-black">{{ $service->service_name }}</p>
                                            <p class="tw-text-gray-600 tw-text-xs">[{{$item->service_name}}]</p>
                                            @if($item->cloth_id)
                                                @php $cloth = \App\Models\Cloth::find($item->cloth_id); @endphp
                                                @if($cloth)
                                                    <span class="badge bg-secondary-100 text-secondary-600 tw-text-[10px]">Cloth: {{ $cloth->cloth_name }}</span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-primary">{{ getFormattedCurrency($item->service_price) }}</td>
                                <td>{{ $item->service_quantity }}</td>
                                <td class="text-primary">{{ getFormattedCurrency($item->service_detail_total) }}</td>
                            </tr>
                            @endforeach
                      </tbody>
                    </table>
                </div>

                <div class="tw-flex tw-flex-col">
                    <div class="tw-flex tw-justify-between tw-items-start tw-mt-6">
                        <div class="tw-flex tw-flex-col ">
                            <div class="">{{ $lang->data['invoice_to'] ?? 'Invoice To' }}</div>
                            <div class="tw-mt-2 tw-font-medium tw-text-sm">{{ $customer->name }}</div>
                            <div class="tw-text-sm">{{$customer->phone ? getCountryCode() : ''}} {{ (int)$customer->phone }}</div>
                            <div class=" tw-text-sm">{{ $customer->email }}</div>
                            <div class=" tw-text-sm">{{ $customer->address }}</div>
                        </div>

                        <div class="tw-flex tw-flex-col ">
                            <div class="pb-2">{{ $lang->data['payment_summary'] ?? 'Payment Summary' }}</div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem] tw-mt-2">
                                <div class="tw-text-sm">{{ $lang->data['sub_total'] ?? 'Sub Total' }}</div>
                                <div class="tw-text-sm">{{ getFormattedCurrency($order->sub_total) }}</div>
                            </div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem]">
                                <div class="tw-text-sm">{{ $lang->data['addon'] ?? 'Addon' }}</div>
                                <div class="tw-text-sm">{{ getFormattedCurrency($order->addon_total) }}</div>
                            </div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem]">
                                <div class="tw-text-sm">{{ $lang->data['tax'] ?? 'Tax' }} ({{ $order->tax_percentage }}%)</div>
                                <div class="tw-text-sm">{{ getFormattedCurrency($order->tax_amount) }}</div>
                            </div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem] tw-mt-2  ">
                                <div class=" tw-font-bold tw-text-sm">{{ $lang->data['gross_total'] ?? 'Gross Total' }}</div>
                                <div class="tw-font-bold tw-text-sm">{{ getFormattedCurrency($order->total) }}</div>
                            </div>
                        </div>
                    </div>
                    <hr class="tw-mt-4">
                    <div class="tw-flex tw-justify-between tw-text-sm tw-mt-4 ">
                        <div class=""><span class="tw-font-medium">{{ $lang->data['notes'] ?? 'Notes' }} :</span> {{ $order->note }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card h-100 p-24 radius-12 lg:tw-w-[24rem] tw-w-full tw-shrink-0">
            <div class="tw-text-xl tw-font-medium mb-3">{{ $lang->data['payments'] ?? 'Payments' }}</div>
            @foreach ($payments as $item)
            <div class="tw-flex tw-items-center tw-pt-2 tw-text-sm tw-gap-4">
                <div class="tw-flex tw-flex-col">
                    <div class="tw-font-medium">{{ getFormattedCurrency($item->received_amount) }}</div>
                    <div class="tw-text-xs tw-font-light tw-mt-1">{{ Carbon\Carbon::parse($item->payment_date)->format('d/m/Y') }} <span class="tw-font-bold">[{{ getpaymentMode($item->payment_type) }}]</span></div>
                </div>
            </div>
            @endforeach
            <div class="mt-4">
                <div class="tw-flex tw-justify-between tw-text-sm">
                    <span>{{ $lang->data['balance'] ?? 'Balance' }}:</span>
                    <span class="tw-font-bold">{{ getFormattedCurrency($balance) }}</span>
                </div>
            </div>
            <a href="{{route('customer.order.print',$order->id)}}" target="_blank" type="button" class="btn btn-outline-warning-600 radius-8 px-20 py-11 tw-mt-3 tw-w-full">{{ $lang->data['print_invoice'] ?? 'Print Invoice' }}</a>
        </div>
    </div>
</div>
