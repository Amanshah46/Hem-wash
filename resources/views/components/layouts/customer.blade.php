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
    <x-theme-component/>
    
    <style>
        body {
            background-color: #f8f9fa !important;
            font-size: 14px;
        }
        .customer-sidebar {
            background: var(--customer-sidebar-gradient, linear-gradient(135deg, #1e3c72 0%, #2a5298 100%));
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
            color: rgba(255, 255, 255, 0.7) !important;
            border-radius: 8px;
            padding: 10px 16px;
            margin-bottom: 4px;
            text-decoration: none;
        }
        .customer-nav-link:hover, .customer-nav-link.active {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.15) !important;
            transform: translateX(4px);
            text-decoration: none;
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

<body class="bg-light" style="font-size: 14px;">
    <div class="d-flex min-vh-100">
        <!-- Sidebar -->
        <aside class="customer-sidebar d-none d-md-flex flex-column flex-shrink-0 text-white" style="width: 256px;">
            <div class="p-4 d-flex align-items-center gap-3 border-bottom border-white-10" style="border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;">
                <img src="{{ asset('assets/images/laundry_icon.png') }}" style="width: 32px; height: 32px;" alt="Logo">
                <span class="fw-bold fs-5 tracking-wide text-white">Customer Portal</span>
            </div>
            
            <nav class="flex-grow-1 p-3 mt-3">
                <a href="{{ route('customer.dashboard') }}" class="customer-nav-link d-flex align-items-center gap-3 {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    <iconify-icon icon="solar:widget-outline" class="fs-5"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('customer.orders.create') }}" class="customer-nav-link d-flex align-items-center gap-3 {{ request()->routeIs('customer.orders.create') ? 'active' : '' }}">
                    <iconify-icon icon="solar:cart-large-minimalistic-outline" class="fs-5"></iconify-icon>
                    <span>New Order</span>
                </a>
                <a href="{{ route('customer.orders') }}" class="customer-nav-link d-flex align-items-center gap-3 {{ request()->routeIs('customer.orders') && !request()->routeIs('customer.orders.create') ? 'active' : '' }}">
                    <iconify-icon icon="solar:clipboard-list-outline" class="fs-5"></iconify-icon>
                    <span>My Orders</span>
                </a>
                <a href="{{ route('customer.profile') }}" class="customer-nav-link d-flex align-items-center gap-3 {{ request()->routeIs('customer.profile') ? 'active' : '' }}">
                    <iconify-icon icon="solar:user-id-outline" class="fs-5"></iconify-icon>
                    <span>My Profile</span>
                </a>
            </nav>
            
            <div class="p-3 border-top border-white-10" style="border-top: 1px solid rgba(255, 255, 255, 0.1) !important;">
                <div class="d-flex align-items-center gap-3 mb-3 px-2">
                    <div class="rounded-circle bg-white-20 d-flex align-items-center justify-content-center fw-bold text-white" style="width: 32px; height: 32px; background: rgba(255, 255, 255, 0.2);">
                        {{ substr(Auth::guard('customer')->user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <div class="fw-semibold text-truncate text-sm text-white">{{ Auth::guard('customer')->user()->name }}</div>
                        <div class="text-xs text-white-50 text-truncate">{{ Auth::guard('customer')->user()->email }}</div>
                    </div>
                </div>
                <a href="{{ route('customer.logout') }}" class="d-flex align-items-center gap-3 w-100 text-start text-danger-light py-2 px-3 rounded text-decoration-none" style="color: #ffcdd2; background: transparent; transition: all 0.2s;" onmouseover="this.style.background='rgba(220, 53, 69, 0.15)'; this.style.color='#f8d7da'" onmouseout="this.style.background='transparent'; this.style.color='#ffcdd2'">
                    <iconify-icon icon="solar:logout-outline" class="fs-5"></iconify-icon>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-grow-1 d-flex flex-column min-w-0">
            <!-- Navbar -->
            <header class="customer-navbar d-flex align-items-center justify-content-between px-4 shadow-sm sticky-top" style="height: 64px;">
                <div class="d-flex align-items-center gap-3">
                    <!-- Mobile Hamburger -->
                    <button class="d-md-none border-0 bg-transparent text-secondary fs-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                        <iconify-icon icon="solar:hamburger-menu-outline"></iconify-icon>
                    </button>
                    <h5 class="mb-0 fw-bold text-dark">{{ $title ?? 'Overview' }}</h5>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-sm-block">
                        <div class="fw-semibold text-dark">{{ Auth::guard('customer')->user()->name }}</div>
                        <div class="text-xs text-secondary">Customer</div>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold fs-5" style="width: 40px; height: 40px; background-color: var(--primary-100); color: var(--laundry-primary);">
                        {{ substr(Auth::guard('customer')->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Page Slot -->
            <main class="flex-grow-1 p-4">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Mobile Menu Offcanvas -->
    <div class="offcanvas offcanvas-start text-white" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel" style="background: var(--customer-sidebar-gradient, linear-gradient(135deg, #1e3c72 0%, #2a5298 100%)) !important;">
        <div class="offcanvas-header border-bottom border-white-10" style="border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;">
            <h5 class="offcanvas-title text-white fw-bold d-flex align-items-center gap-2" id="mobileMenuLabel">
                <img src="{{ asset('assets/images/laundry_icon.png') }}" style="width: 32px; height: 32px;" alt="Logo">
                Customer Portal
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column justify-content-between p-4">
            <nav class="d-flex flex-column gap-2">
                <a href="{{ route('customer.dashboard') }}" class="customer-nav-link d-flex align-items-center gap-3 {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                    <iconify-icon icon="solar:widget-outline" class="fs-5"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('customer.orders.create') }}" class="customer-nav-link d-flex align-items-center gap-3 {{ request()->routeIs('customer.orders.create') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                    <iconify-icon icon="solar:cart-large-minimalistic-outline" class="fs-5"></iconify-icon>
                    <span>New Order</span>
                </a>
                <a href="{{ route('customer.orders') }}" class="customer-nav-link d-flex align-items-center gap-3 {{ request()->routeIs('customer.orders') && !request()->routeIs('customer.orders.create') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                    <iconify-icon icon="solar:clipboard-list-outline" class="fs-5"></iconify-icon>
                    <span>My Orders</span>
                </a>
                <a href="{{ route('customer.profile') }}" class="customer-nav-link d-flex align-items-center gap-3 {{ request()->routeIs('customer.profile') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                    <iconify-icon icon="solar:user-id-outline" class="fs-5"></iconify-icon>
                    <span>My Profile</span>
                </a>
            </nav>
            <div class="pt-4 border-top border-white-10" style="border-top: 1px solid rgba(255, 255, 255, 0.1) !important;">
                <div class="d-flex align-items-center gap-3 mb-4 px-2">
                    <div class="rounded-circle bg-white-20 d-flex align-items-center justify-content-center fw-bold text-white" style="width: 32px; height: 32px; background: rgba(255, 255, 255, 0.2);">
                        {{ substr(Auth::guard('customer')->user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <div class="fw-semibold text-white text-sm truncate">{{ Auth::guard('customer')->user()->name }}</div>
                        <div class="text-xs text-white-50 truncate">{{ Auth::guard('customer')->user()->email }}</div>
                    </div>
                </div>
                <a href="{{ route('customer.logout') }}" class="d-flex align-items-center gap-3 w-100 text-start text-danger-light py-2 px-3 rounded text-decoration-none" style="color: #ffcdd2; background: transparent; transition: all 0.2s;" onmouseover="this.style.background='rgba(220, 53, 69, 0.15)'; this.style.color='#f8d7da'" onmouseout="this.style.background='transparent'; this.style.color='#ffcdd2'">
                    <iconify-icon icon="solar:logout-outline" class="fs-5"></iconify-icon>
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
