<div>
    <div class="row gy-4">

        {{-- ─────────────── Profile Info Card ─────────────── --}}
        <div class="col-lg-7">
            <div class="card radius-16 customer-card-glass h-100">
                <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center gap-3">
                    <div class="w-40-px h-40-px radius-8 d-flex align-items-center justify-content-center"
                         style="background: var(--customer-sidebar-gradient, linear-gradient(135deg,#1e3c72,#2a5298));">
                        <iconify-icon icon="solar:user-id-bold" class="text-white tw-text-xl"></iconify-icon>
                    </div>
                    <div>
                        <h6 class="mb-0 tw-font-bold text-gray-800">Personal Information</h6>
                        <span class="text-secondary-light text-sm">Update your name, email and contact details</span>
                    </div>
                </div>

                <div class="card-body p-24">
                    {{-- Avatar / greeting --}}
                    <div class="d-flex align-items-center gap-4 mb-24 p-16 radius-12"
                         style="background: var(--customer-sidebar-gradient, linear-gradient(135deg,#1e3c72 0%,#2a5298 100%));">
                        <div class="tw-w-16 tw-h-16 tw-rounded-full tw-bg-white/20 tw-flex tw-items-center
                                    tw-justify-center tw-font-bold text-white"
                             style="font-size:1.75rem;">
                            {{ strtoupper(substr(Auth::guard('customer')->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-bold text-white tw-text-lg">{{ Auth::guard('customer')->user()->name }}</div>
                            <div class="text-white-50 text-sm">{{ Auth::guard('customer')->user()->email }}</div>
                        </div>
                    </div>

                    <form wire:submit.prevent="updateProfile">

                        <div class="row gy-3">
                            {{-- Full Name --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold text-secondary-light text-sm mb-1">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative">
                                    <span class="position-absolute top-50 translate-middle-y ms-3 text-secondary-light">
                                        <iconify-icon icon="solar:user-outline"></iconify-icon>
                                    </span>
                                    <input type="text" id="profile-name"
                                           class="form-control ps-5 radius-8 @error('name') is-invalid @enderror"
                                           wire:model="name" placeholder="Your full name">
                                </div>
                                @error('name')
                                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold text-secondary-light text-sm mb-1">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative">
                                    <span class="position-absolute top-50 translate-middle-y ms-3 text-secondary-light">
                                        <iconify-icon icon="solar:letter-outline"></iconify-icon>
                                    </span>
                                    <input type="email" id="profile-email"
                                           class="form-control ps-5 radius-8 @error('email') is-invalid @enderror"
                                           wire:model="email" placeholder="your@email.com">
                                </div>
                                @error('email')
                                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold text-secondary-light text-sm mb-1">
                                    Phone Number <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative">
                                    <span class="position-absolute top-50 translate-middle-y ms-3 text-secondary-light">
                                        <iconify-icon icon="solar:phone-outline"></iconify-icon>
                                    </span>
                                    <input type="text" id="profile-phone"
                                           class="form-control ps-5 radius-8 @error('phone') is-invalid @enderror"
                                           wire:model="phone" placeholder="+1 (555) 000-0000">
                                </div>
                                @error('phone')
                                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Address --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold text-secondary-light text-sm mb-1">
                                    Address
                                </label>
                                <div class="position-relative">
                                    <span class="position-absolute ms-3 text-secondary-light" style="top:12px;">
                                        <iconify-icon icon="solar:map-point-outline"></iconify-icon>
                                    </span>
                                    <textarea id="profile-address" rows="2"
                                              class="form-control ps-5 radius-8 @error('address') is-invalid @enderror"
                                              wire:model="address" placeholder="Your delivery/billing address"></textarea>
                                </div>
                                @error('address')
                                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>

                        <div class="mt-24 d-flex justify-content-end">
                            <button type="submit" id="btn-update-profile"
                                    class="btn btn-primary radius-8 px-24 py-10 d-flex align-items-center gap-2"
                                    style="background: var(--customer-sidebar-gradient, linear-gradient(135deg,#1e3c72,#2a5298)); border:none;">
                                <div wire:loading wire:target="updateProfile"
                                     class="spinner-border spinner-border-sm text-white" role="status"></div>
                                <iconify-icon icon="solar:check-circle-bold" wire:loading.remove wire:target="updateProfile"></iconify-icon>
                                <span>Save Changes</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ─────────────── Change Password Card ─────────────── --}}
        <div class="col-lg-5">
            <div class="card radius-16 customer-card-glass h-100">
                <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center gap-3">
                    <div class="w-40-px h-40-px radius-8 d-flex align-items-center justify-content-center"
                         style="background: var(--customer-sidebar-gradient, linear-gradient(135deg,#1e3c72,#2a5298));">
                        <iconify-icon icon="solar:lock-password-bold" class="text-white tw-text-xl"></iconify-icon>
                    </div>
                    <div>
                        <h6 class="mb-0 tw-font-bold text-gray-800">Change Password</h6>
                        <span class="text-secondary-light text-sm">Keep your account secure</span>
                    </div>
                </div>

                <div class="card-body p-24">

                    {{-- Security tips banner --}}
                    <div class="p-12 radius-8 mb-20 d-flex align-items-start gap-3"
                         style="background: var(--primary-50); border-left:4px solid var(--laundry-primary);">
                        <iconify-icon icon="solar:shield-check-outline" class="text-primary-600 tw-text-lg tw-flex-shrink-0 mt-1"></iconify-icon>
                        <p class="mb-0 text-secondary-light text-sm">
                            Use at least <strong>6 characters</strong>. A strong password mixes letters, numbers, and symbols.
                        </p>
                    </div>

                    <form wire:submit.prevent="updatePassword">
                        <div class="d-flex flex-column gap-3">

                            {{-- Current Password --}}
                            <div>
                                <label class="form-label fw-semibold text-secondary-light text-sm mb-1">
                                    Current Password <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative">
                                    <span class="position-absolute top-50 translate-middle-y ms-3 text-secondary-light">
                                        <iconify-icon icon="solar:lock-outline"></iconify-icon>
                                    </span>
                                    <input type="password" id="current-password"
                                           class="form-control ps-5 radius-8 @error('current_password') is-invalid @enderror"
                                           wire:model="current_password" placeholder="Enter current password"
                                           autocomplete="current-password">
                                </div>
                                @error('current_password')
                                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div>
                                <label class="form-label fw-semibold text-secondary-light text-sm mb-1">
                                    New Password <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative">
                                    <span class="position-absolute top-50 translate-middle-y ms-3 text-secondary-light">
                                        <iconify-icon icon="solar:lock-keyhole-outline"></iconify-icon>
                                    </span>
                                    <input type="password" id="new-password"
                                           class="form-control ps-5 radius-8 @error('new_password') is-invalid @enderror"
                                           wire:model="new_password" placeholder="Enter new password (min 6 chars)"
                                           autocomplete="new-password">
                                </div>
                                @error('new_password')
                                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm New Password --}}
                            <div>
                                <label class="form-label fw-semibold text-secondary-light text-sm mb-1">
                                    Confirm New Password <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative">
                                    <span class="position-absolute top-50 translate-middle-y ms-3 text-secondary-light">
                                        <iconify-icon icon="solar:lock-keyhole-minimalistic-outline"></iconify-icon>
                                    </span>
                                    <input type="password" id="confirm-new-password"
                                           class="form-control ps-5 radius-8"
                                           wire:model="new_password_confirmation" placeholder="Re-type new password"
                                           autocomplete="new-password">
                                </div>
                            </div>

                        </div>

                        <div class="mt-24 d-flex justify-content-end">
                            <button type="submit" id="btn-change-password"
                                    class="btn btn-warning radius-8 px-24 py-10 d-flex align-items-center gap-2 text-white fw-semibold"
                                    style="background: linear-gradient(135deg,#f7971e,#ffd200); border:none; color:#333 !important;">
                                <div wire:loading wire:target="updatePassword"
                                     class="spinner-border spinner-border-sm" role="status"></div>
                                <iconify-icon icon="solar:shield-check-bold" wire:loading.remove wire:target="updatePassword"></iconify-icon>
                                <span class="text-dark">Update Password</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
