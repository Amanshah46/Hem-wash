<section class="auth bg-base d-flex flex-wrap">
    <div class="auth-left d-lg-block d-none">
        <div class="d-flex align-items-center flex-column h-100 justify-content-center">
            <img src="{{asset('assets/images/login-bg.jpg')}}" class="tw-h-full object-fit-cover tw-w-full" alt="">
        </div>
    </div>
    <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center tw-relative tw-inset-0 tw-items-center  ">
        <div class="max-w-464-px mx-auto w-100 tw-absolute tw-inset-0 tw-flex center tw-flex-col tw-justify-center lg:tw-px-0 tw-px-14" x-transition >
            <div>
                <div class="tw-w-full tw-flex tw-items-center tw-justify-center">
                    <a href="#" class="tw-mb-8 max-w-290-px ">
                        <img src="{{asset('assets/images/logo-ct.png')}}" alt="" class="tw-max-h-24 tw-object-contain">
                    </a>
                </div>

                <h4 class="mb-12">Customer Sign In</h4>
                <p class="mb-32 text-secondary-light text-lg">Access the customer portal</p>
            </div>
            <form action="#">
                <div class="icon-field">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="mage:email"></iconify-icon>
                    </span>
                    <input type="email" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Email" wire:model="email">
                </div>
                @error('email') <span class="text-danger">{{$message}}</span>  @enderror

                <div class="position-relative mt-16">
                    <div class="icon-field">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                        </span>
                        <input type="password" class="form-control h-56-px bg-neutral-50 radius-12" id="your-password" placeholder="Password" wire:model="password">
                    </div>
                    @error('password') <span class="text-danger">{{$message}}</span>  @enderror
                    @error('login_error') <span class="text-danger">{{$message}}</span>  @enderror
                </div>

                <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32" wire:click.prevent="login">
                     Sign In
                     <div class="spinner-border tw-size-3" role="status" wire:loading="login">
                        <span class="visually-hidden">Loading...</span>
                        </div>
                    </button>

                <div class="mt-32 text-center">
                    <p>Don't have an account? <a href="{{ route('customer.signup') }}" class="text-primary-600 fw-semibold">Sign Up</a></p>
                    <hr class="my-24">
                    <p>Are you an Admin? <a href="{{ route('login') }}" class="text-secondary-600 fw-semibold">Login as Admin</a></p>
                </div>
            </form>
        </div>
    </div>
</section>
