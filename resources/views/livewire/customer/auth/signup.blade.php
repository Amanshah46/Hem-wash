<section class="auth bg-base d-flex flex-wrap">
    <div class="auth-left d-lg-block d-none">
        <div class="d-flex align-items-center flex-column h-100 justify-content-center">
            <img src="{{ asset('assets/images/login-bg.jpg') }}" class="tw-h-full object-fit-cover tw-w-full" alt="">
        </div>
    </div>
    <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center tw-relative tw-inset-0 tw-items-center">
        <div class="max-w-464-px mx-auto w-100">
            <div>
                <div class="tw-w-full tw-flex tw-items-center tw-justify-center">
                    <a href="#" class="tw-mb-8 max-w-290-px">
                        <img src="{{ asset('assets/images/logo-ct.png') }}" alt="" class="tw-max-h-24 tw-object-contain">
                    </a>
                </div>
                <h4 class="mb-12">Create Customer Account</h4>
                <p class="mb-32 text-secondary-light text-lg">Enter your details to register</p>
            </div>
            <form wire:submit.prevent="signup">
                <div class="icon-field mb-16">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="f7:person"></iconify-icon>
                    </span>
                    <input type="text" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Full Name" wire:model="name">
                </div>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror

                <div class="icon-field mb-16">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="mage:email"></iconify-icon>
                    </span>
                    <input type="email" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Email Address" wire:model="email">
                </div>
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror

                <div class="icon-field mb-16">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="solar:phone-outline"></iconify-icon>
                    </span>
                    <input type="text" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Phone Number" wire:model="phone">
                </div>
                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror

                <div class="icon-field mb-16">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                    </span>
                    <input type="password" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Password" wire:model="password">
                </div>
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror

                <div class="icon-field mb-16">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                    </span>
                    <input type="password" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Confirm Password" wire:model="password_confirmation">
                </div>

                <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32">
                    Sign Up
                    <div class="spinner-border tw-size-3" role="status" wire:loading wire:target="signup">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </button>

                <div class="mt-32 text-center">
                    <p>Already have an account? <a href="{{ route('customer.login') }}" class="text-primary-600 fw-semibold">Sign In</a></p>
                </div>
            </form>
        </div>
    </div>
</section>
