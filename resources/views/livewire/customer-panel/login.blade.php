<section class="auth bg-base d-flex flex-wrap" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%) !important;">  
    <div class="auth-left d-lg-block d-none" style="flex: 1; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
        <div class="d-flex align-items-center flex-column h-100 justify-content-center text-white p-5 text-center">
            <img src="{{ asset('assets/images/laundry_icon.png') }}" class="tw-h-32 tw-w-32 tw-mb-6 tw-animate-bounce" alt="Logo">
            <h1 class="tw-text-4xl tw-font-bold tw-mb-4">Laundry Box</h1>
            <p class="tw-text-lg tw-text-white/80 tw-max-w-md">Schedule pickups, track your clothes, and view orders from our premium customer portal.</p>
        </div>
    </div>
    <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center tw-relative tw-inset-0 tw-items-center" style="flex: 1;">
        <div class="max-w-464-px mx-auto w-100 tw-flex tw-flex-col tw-justify-center lg:tw-px-0 tw-px-14">
            <div class="text-center tw-mb-8">
                <a href="#" class="tw-mb-4 d-inline-block">
                    <img src="{{ asset('assets/images/logo-ct.png') }}" alt="Logo" class="tw-max-h-16 tw-object-contain">
                </a>
                <h3 class="tw-font-bold tw-text-gray-800 mt-3">Customer Portal</h3>
                <p class="text-secondary-light">Please sign in to manage your laundry orders</p>
            </div>
            
            <form wire:submit.prevent="login">
                @if (session()->has('success_register'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success_register') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="icon-field tw-mb-4">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="mage:email"></iconify-icon>
                    </span>
                    <input type="email" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Email Address" wire:model="email"> 
                </div>
                @error('email') <span class="text-danger d-block tw-mb-2">{{ $message }}</span> @enderror

                <div class="position-relative tw-mb-4">
                    <div class="icon-field">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                        </span> 
                        <input type="password" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Password" wire:model="password">
                    </div>
                    @error('password') <span class="text-danger d-block tw-mt-1">{{ $message }}</span> @enderror
                    @error('login_error') <span class="text-danger d-block tw-mt-2 tw-font-semibold">{{ $message }}</span> @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mt-20">
                    <div class="form-check style-check d-flex align-items-center">
                        <input class="form-check-input border border-neutral-300" type="checkbox" id="remember">
                        <label class="form-check-label text-sm text-secondary-light" for="remember">Remember me</label>
                    </div>
                    <a href="{{ route('customer.register') }}" class="text-primary-600 fw-semibold text-sm">Create an Account</a>
                </div>

                <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32 d-flex align-items-center justify-content-center gap-2">
                    <span>Sign In</span>
                    <div class="spinner-border tw-size-3" role="status" wire:loading wire:target="login">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </button>
            </form>
        </div>
    </div>
</section>
