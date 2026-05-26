<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(isRTL() == true) dir="rtl" @endif>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/laundry_icon.png') }}" sizes="16x16">
    <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/flatpickr.min.css') }}">
    <link href="{{asset('assets/plugins/toastr.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @vite('resources/css/app.css')
    <title>{{ $title ?? 'Customer Portal' }}</title>
    
    <style>
        .customer-sidebar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(4px);
            border-right: 1px solid rgba(255, 255, 255, 0.18);
        }
        .customer-navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.18);
        }
        .customer-nav-link {
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.7);
            border-radius: 8px;
            padding: 10px 16px;
            margin-bottom: 4px;
        }
        .customer-nav-link:hover, .customer-nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(4px);
        }
        .customer-card-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.05);
            border-radius: 12px;
        }
    </style>
</head>

<body class="tw-bg-gray-50 tw-text-sm">
    <div class="tw-flex tw-min-h-screen">
        <!-- Sidebar -->
        <aside class="customer-sidebar tw-w-64 tw-text-white tw-flex-shrink-0 tw-hidden md:tw-flex tw-flex-col">
            <div class="tw-p-6 tw-flex tw-items-center tw-gap-3 tw-border-b tw-border-white/10">
                <img src="{{ asset('assets/images/laundry_icon.png') }}" class="tw-w-8 tw-h-8" alt="Logo">
                <span class="tw-font-bold tw-text-lg tw-tracking-wide">Customer Portal</span>
            </div>
            
            <nav class="tw-flex-1 tw-p-4 tw-mt-4">
                <a href="{{ route('customer.dashboard') }}" class="customer-nav-link tw-flex tw-items-center tw-gap-3 {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    <iconify-icon icon="solar:widget-outline" class="tw-text-xl"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('customer.orders.create') }}" class="customer-nav-link tw-flex tw-items-center tw-gap-3 {{ request()->routeIs('customer.orders.create') ? 'active' : '' }}">
                    <iconify-icon icon="solar:cart-large-minimalistic-outline" class="tw-text-xl"></iconify-icon>
                    <span>New Order</span>
                </a>
                <a href="{{ route('customer.orders') }}" class="customer-nav-link tw-flex tw-items-center tw-gap-3 {{ request()->routeIs('customer.orders') && !request()->routeIs('customer.orders.create') ? 'active' : '' }}">
                    <iconify-icon icon="solar:clipboard-list-outline" class="tw-text-xl"></iconify-icon>
                    <span>My Orders</span>
                </a>
            </nav>
            
            <div class="tw-p-4 tw-border-t tw-border-white/10">
                <div class="tw-flex tw-items-center tw-gap-3 tw-mb-4 tw-px-2">
                    <div class="tw-w-8 tw-h-8 tw-rounded-full tw-bg-white/20 tw-flex tw-items-center tw-justify-center tw-font-bold">
                        {{ substr(Auth::guard('customer')->user()->name, 0, 1) }}
                    </div>
                    <div class="tw-overflow-hidden">
                        <div class="tw-font-semibold tw-truncate tw-text-sm">{{ Auth::guard('customer')->user()->name }}</div>
                        <div class="tw-text-xs tw-text-white/60 tw-truncate">{{ Auth::guard('customer')->user()->email }}</div>
                    </div>
                </div>
                <a href="{{ route('customer.logout') }}" class="tw-flex tw-items-center tw-gap-3 tw-w-full tw-text-left tw-text-red-300 hover:tw-text-red-100 tw-py-2 tw-px-4 tw-rounded-lg hover:tw-bg-red-500/10 tw-transition-colors">
                    <iconify-icon icon="solar:logout-outline" class="tw-text-xl"></iconify-icon>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="tw-flex-1 tw-flex tw-flex-col tw-min-w-0">
            <!-- Navbar -->
            <header class="customer-navbar tw-h-16 tw-flex tw-items-center tw-justify-between tw-px-6 tw-shadow-sm sticky-top">
                <div class="tw-flex tw-items-center tw-gap-4">
                    <!-- Mobile Hamburger -->
                    <button class="md:tw-hidden tw-text-gray-600 tw-text-2xl" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                        <iconify-icon icon="solar:hamburger-menu-outline"></iconify-icon>
                    </button>
                    <h5 class="mb-0 tw-font-bold tw-text-gray-800">{{ $title ?? 'Overview' }}</h5>
                </div>
                
                <div class="tw-flex tw-items-center tw-gap-4">
                    <div class="tw-text-right tw-hidden sm:tw-block">
                        <div class="tw-font-semibold tw-text-gray-800">{{ Auth::guard('customer')->user()->name }}</div>
                        <div class="tw-text-xs tw-text-gray-500">Customer</div>
                    </div>
                    <div class="tw-w-10 tw-h-10 tw-rounded-full tw-bg-blue-100 tw-text-blue-600 tw-flex tw-items-center tw-justify-center tw-font-bold tw-text-lg">
                        {{ substr(Auth::guard('customer')->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Page Slot -->
            <main class="tw-flex-1 tw-p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Mobile Menu Offcanvas -->
    <div class="offcanvas offcanvas-start bg-primary text-white" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
        <div class="offcanvas-header border-bottom border-white/10">
            <h5 class="offcanvas-title text-white fw-bold d-flex align-items-center gap-2" id="mobileMenuLabel">
                <img src="{{ asset('assets/images/laundry_icon.png') }}" class="tw-w-8 tw-h-8" alt="Logo">
                Customer Portal
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column justify-content-between p-4">
            <nav class="d-flex flex-column gap-2">
                <a href="{{ route('customer.dashboard') }}" class="customer-nav-link tw-flex tw-items-center tw-gap-3 {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                    <iconify-icon icon="solar:widget-outline" class="tw-text-xl"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('customer.orders.create') }}" class="customer-nav-link tw-flex tw-items-center tw-gap-3 {{ request()->routeIs('customer.orders.create') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                    <iconify-icon icon="solar:cart-large-minimalistic-outline" class="tw-text-xl"></iconify-icon>
                    <span>New Order</span>
                </a>
                <a href="{{ route('customer.orders') }}" class="customer-nav-link tw-flex tw-items-center tw-gap-3 {{ request()->routeIs('customer.orders') && !request()->routeIs('customer.orders.create') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                    <iconify-icon icon="solar:clipboard-list-outline" class="tw-text-xl"></iconify-icon>
                    <span>My Orders</span>
                </a>
            </nav>
            <div class="pt-4 border-top border-white/10">
                <div class="d-flex align-items-center gap-3 mb-4 px-2">
                    <div class="tw-w-8 tw-h-8 tw-rounded-full tw-bg-white/20 tw-flex tw-items-center tw-justify-center tw-font-bold">
                        {{ substr(Auth::guard('customer')->user()->name, 0, 1) }}
                    </div>
                    <div class="tw-overflow-hidden">
                        <div class="tw-font-semibold text-white text-sm truncate">{{ Auth::guard('customer')->user()->name }}</div>
                        <div class="tw-text-xs text-white-50 truncate">{{ Auth::guard('customer')->user()->email }}</div>
                    </div>
                </div>
                <a href="{{ route('customer.logout') }}" class="tw-flex tw-items-center tw-gap-3 tw-w-full tw-text-left tw-text-red-300 hover:tw-text-red-100 tw-py-2 tw-px-4 tw-rounded-lg hover:tw-bg-red-500/10 tw-transition-colors">
                    <iconify-icon icon="solar:logout-outline" class="tw-text-xl"></iconify-icon>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/iconify-icon.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr.min.js') }}"></script>
    
    <script>
        "use strict";
        document.addEventListener('livewire:init', () => {
            Livewire.on('closemodal', (event) => {
                $('.modal').modal('hide');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').removeAttr('style');
            });
            Livewire.on('alert', (event) => {
                toastr[event[0].type](event[0].message, 
                event[0].title ?? ''), toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                }
            });
            Livewire.on('reloadpage', (event) => {
                window.location.reload()
            });
        });
    </script>
    @stack('js')
</body>
</html>
