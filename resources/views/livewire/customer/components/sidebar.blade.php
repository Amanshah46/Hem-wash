<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="#" class="sidebar-logo">
            <img src="/assets/images/logo.jpeg" alt="site logo" class="light-logo">
            <img src="/assets/images/logo-light.png" alt="site logo" class="dark-logo">
            <img src="/assets/images/laundry_icon.png" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="{{ route('customer.orders') }}">
                    <iconify-icon icon="akar-icons:cart" class="menu-icon"></iconify-icon>
                    <span>{{ $lang->data['my_orders'] ?? 'My Orders' }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('customer.order.create') }}">
                    <iconify-icon icon="ic:baseline-plus" class="menu-icon"></iconify-icon>
                    <span>{{ $lang->data['add_order'] ?? 'Add Order' }}</span>
                </a>
            </li>
            <li class="sidebar-menu-group-title">{{$lang->data['account'] ?? 'Account'}}</li>
            <li>
                <a href="{{route('customer.logout')}}">
                    <iconify-icon icon="material-symbols:logout" class="menu-icon"></iconify-icon>
                    <span>{{ $lang->data['logout'] ?? 'Logout' }}</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
