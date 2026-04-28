<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="#" class="sidebar-logo">
            <img src="/assets/images/logo.png" alt="site logo" class="light-logo">
            <img src="/assets/images/logo-light.png" alt="site logo" class="dark-logo">
            <img src="/assets/images/laundry_icon.png" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>{{$lang->data['dashboard'] ?? 'Dashboard'}}</span>
                </a>
            </li>
            @canany(['order_create','order_list','order_status_change'])
                <li class="sidebar-menu-group-title">{{$lang->data['orders'] ?? 'Orders'}}</li>
            @endcan
            @can('order_create')
            <li>
                <a href="{{route('orders.pos')}}">
                    <iconify-icon icon="mdi-light:monitor" class="menu-icon"></iconify-icon>
                    <span>{{ $lang->data['pos'] ?? 'POS' }}</span>
                </a>
            </li>
            @endcan
            @can('order_list')
            <li>
                <a href="{{ route('orders') }}">
                    <iconify-icon icon="akar-icons:cart" class="menu-icon"></iconify-icon>
                    <span>{{ $lang->data['orders'] ?? 'Orders' }}</span>
                </a>
            </li>
            @endcan
            @can('order_status_change')
            <li>
                <a href="{{ route('orders.status-screen') }}">
                    <iconify-icon icon="line-md:list-3-filled" class="menu-icon"></iconify-icon>
                    <span>{{ $lang->data['order_status_screen'] ?? 'Order Status Screen' }}</span>
                </a>
            </li>
            @endcan
            <li class="sidebar-menu-group-title">{{ $lang->data['application'] ?? 'Application' }}</li>
            @can('customer_list')
            <li class="@if(Request::is('admin/customers*')) active-page @endif">
                <a href="{{ route('customers') }}" class="@if(Request::is('admin/customers*')) active-page @endif">
                    <iconify-icon icon="uil:user" class="menu-icon"></iconify-icon>
                    <span>{{ $lang->data['customers'] ?? 'Customers' }}</span>
                </a>
            </li>   
            @endcan
            @canany(['service_list','service_type_list','addon_list'])
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="material-symbols-light:design-services-outline-sharp" class="menu-icon"></iconify-icon>
                    <span>{{$lang->data['services'] ?? 'Services'}}</span>
                </a>
                <ul class="sidebar-submenu">
                    @can('service_list')
                    <li>
                        <a href="{{ route('service') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>{{$lang->data['service_list'] ?? 'Service List'}}</a>
                    </li>
                    @endcan
                    @can('service_type_list')
                    <li>
                        <a href="{{ route('service.types') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>{{$lang->data['service_type'] ?? 'Service Type'}}</a>
                    </li>
                    @endcan
                    @can('addon_list')
                    <li>
                        <a href="{{ route('service.addons') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> {{$lang->data['addons'] ?? 'Addons'}}</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany
            @canany(['expense_list','expense_category_list'])
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="iconoir:wallet" class="menu-icon"></iconify-icon>
                    <span>{{$lang->data['expense'] ?? 'Expense'}}</span>
                </a>
                <ul class="sidebar-submenu">
                    @can('expense_list')
                        <li>
                            <a href="{{ route('expense') }}"><i
                                    class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                {{ $lang->data['expense_list'] ?? 'Expense List' }}</a>
                        </li>
                    @endcan
                    @can('expense_category_list')
                        <li>
                            <a href="{{ route('expense.category') }}"><i
                                    class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                {{ $lang->data['expense_category'] ?? 'Expense Category' }}</a>
                        </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('payment_list')
            <li>
                <a href="{{ route('payments.receipt') }}">
                    <iconify-icon icon="fluent:receipt-48-regular" class="menu-icon"></iconify-icon>
                    <span>{{$lang->data['payment_receipt'] ?? 'Payment Receipt'}}</span>
                </a>
            </li>
            @endcan
            @canany(['report_daily','report_order','report_sales','report_expense','report_ledger','report_tax'])
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="iconoir:reports" class="menu-icon"></iconify-icon>
                    <span>{{$lang->data['reports'] ?? 'Reports'}}</span>
                </a>
                <ul class="sidebar-submenu">
                    @can('report_daily')
                    <li>
                        <a href="{{ route('reports.daily') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>{{$lang->data['daily_report'] ?? 'Daily Report'}}</a>
                    </li>
                    @endcan
                    @can('report_order')
                    <li>
                        <a href="{{ route('reports.order') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>{{$lang->data['order_report'] ?? 'Order Report'}}</a>
                    </li>
                    @endcan
                    @can('report_sales')
                    <li>
                        <a href="{{ route('reports.sales') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>{{$lang->data['sales_report'] ?? 'Sales Report'}}</a>
                    </li>
                    @endcan
                    @can('report_ledger')
                    <li>
                        <a href="{{ route('reports.ledger') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>{{$lang->data['ledger_report'] ?? 'Ledger Report'}}</a>
                    </li>
                    @endcan
                    @can('report_expense')
                    <li>
                        <a href="{{ route('reports.expense') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> {{$lang->data['expense_report'] ?? 'Expense Report'}}</a>
                    </li>
                    @endcan
                    @can('report_tax')
                    <li>
                        <a href="{{ route('reports.tax') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>{{$lang->data['tax_report'] ?? 'Tax Report'}}</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany
            <li class="sidebar-menu-group-title">{{$lang->data['account'] ?? 'Account'}}</li>
            @can('setting_view')
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
                    <span>{{$lang->data['tools'] ?? 'Tools'}}</span>
                </a>
                <ul class="sidebar-submenu">
                    @can('setting_financial_year')
                        <li>
                            <a href="{{ route('settings.financial-year') }}"><i
                                    class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>{{$lang->data['financial_year'] ?? 'Financial Year'}}</a>
                        </li>
                    @endcan
                    @can('translation_list')
                    <li>
                        <a href="{{ route('settings.translations') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>{{$lang->data['translations'] ?? 'Translations'}}</a>
                    </li>
                    @endcan
                    @can('setting_mail')
                    <li>
                        <a href="{{ route('settings.mail-settings') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> {{$lang->data['mail_settings'] ?? 'Mail Settings'}}</a>
                    </li>
                    @endcan

                    @can('setting_mail')
                    <li>
                        <a href="{{ route('settings.file') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>{{$lang->data['file_tools'] ?? 'File Tools'}} </a>
                    </li>
                    @endcan
                    @can('setting_sms')
                    <li>
                        <a href="{{ route('settings.sms') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>{{$lang->data['sms_settings'] ?? 'SMS Settings'}} </a>
                    </li>
                    @endcan
                    @can('role_list')
                    <li>
                        <a href="{{ route('settings.roles') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> {{$lang->data['roles'] ?? 'Roles'}} </a>
                    </li>
                    @endcan
                    @can('user_list')
                    <li>
                        <a href="{{ route('settings.staff') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> {{$lang->data['staff'] ?? 'Staff'}} </a>
                    </li>
                    @endcan
                    @can('setting_master')
                    <li>
                        <a href="{{ route('settings.master-settings') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> {{$lang->data['master_settings'] ?? 'Master Settings'}}</a>
                    </li>
                    @endcan
                    @can('setting_theme')
                    <li>
                        <a href="{{ route('settings.theme') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> {{$lang->data['theme'] ?? 'Theme'}}</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            <li>
                <a href="{{route('logout')}}"  wire:click.prevent="logout()">
                    <iconify-icon icon="material-symbols:logout" class="menu-icon"></iconify-icon>
                    <span>{{ $lang->data['logout'] ?? 'Logout' }}</span>
                </a>
            </li>
        </ul>
    </div>
</aside>