<section class="auth bg-base d-flex flex-wrap" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%) !important;">  
    <div class="auth-left d-lg-block d-none" style="flex: 1; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
        <div class="d-flex align-items-center flex-column h-100 justify-content-center text-white p-5 text-center">
            <img src="{{ asset('assets/images/laundry_icon.png') }}" class="tw-h-32 tw-w-32 tw-mb-6 tw-animate-bounce" alt="Logo">
            <h1 class="tw-text-4xl tw-font-bold tw-mb-4">Join Laundry Box</h1>
            <p class="tw-text-lg tw-text-white/80 tw-max-w-md">Create an account to start placing premium laundry orders online, tracking your garments, and managing your payments.</p>
        </div>
    </div>
    <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center tw-relative tw-inset-0 tw-items-center" style="flex: 1; overflow-y: auto;">
        <div class="max-w-464-px mx-auto w-100 tw-flex tw-flex-col tw-justify-center lg:tw-px-0 tw-px-14 tw-py-8">
            <div class="text-center tw-mb-6">
                <a href="#" class="tw-mb-4 d-inline-block">
                    <img src="{{ asset('assets/images/logo-ct.png') }}" alt="Logo" class="tw-max-h-16 tw-object-contain">
                </a>
                <h3 class="tw-font-bold tw-text-gray-800 mt-2">Create Customer Account</h3>
                <p class="text-secondary-light">Register and start ordering today</p>
            </div>
            
            <form wire:submit.prevent="register">
                <div class="icon-field tw-mb-3">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="mage:user-card"></iconify-icon>
                    </span>
                    <input type="text" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Full Name *" wire:model="name"> 
                </div>
                @error('name') <span class="text-danger d-block tw-mb-2">{{ $message }}</span> @enderror

                <div class="icon-field tw-mb-3">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="mage:email"></iconify-icon>
                    </span>
                    <input type="email" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Email Address *" wire:model="email"> 
                </div>
                @error('email') <span class="text-danger d-block tw-mb-2">{{ $message }}</span> @enderror

                <div class="icon-field tw-mb-3">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="solar:phone-outline"></iconify-icon>
                    </span>
                    <input type="text" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Phone Number *" wire:model="phone"> 
                </div>
                @error('phone') <span class="text-danger d-block tw-mb-2">{{ $message }}</span> @enderror

                <div class="icon-field tw-mb-3">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                    </span> 
                    <input type="password" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Password (Min. 6 chars) *" wire:model="password">
                </div>
                @error('password') <span class="text-danger d-block tw-mb-2">{{ $message }}</span> @enderror

                <div class="icon-field tw-mb-3">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="tabler:tax"></iconify-icon>
                    </span> 
                    <input type="text" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Tax/VAT Number (Optional)" wire:model="tax_number">
                </div>
                @error('tax_number') <span class="text-danger d-block tw-mb-2">{{ $message }}</span> @enderror

                <div class="icon-field tw-mb-3">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="entypo:address"></iconify-icon>
                    </span> 
                    <textarea class="form-control bg-neutral-50 radius-12 tw-pl-12 tw-pt-3" style="height: 80px;" placeholder="Address (Optional)" wire:model="address"></textarea>
                </div>
                @error('address') <span class="text-danger d-block tw-mb-2">{{ $message }}</span> @enderror

                <div class="d-flex justify-content-between align-items-center mt-20">
                    <span class="text-xs text-gray-500">* Required fields</span>
                    <a href="{{ route('customer.login') }}" class="text-primary-600 fw-semibold text-sm">Already have an account? Sign In</a>
                </div>

                <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32 d-flex align-items-center justify-content-center gap-2">
                    <span>Sign Up</span>
                    <div class="spinner-border tw-size-3" role="status" wire:loading wire:target="register">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </button>
            </form>
        </div>
    </div>
</section>
