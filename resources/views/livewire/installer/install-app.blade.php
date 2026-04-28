<div class="tw-flex tw-justify-center tw-items-center tw-h-screen tw-w-full tw-overflow-auto py-32" x-data="alpineInstaller">
    <div class=" tw-flex tw-items-center tw-justify-center">
        <div class="card tw-w-[40%] tw-min-w-[40rem]  ">
            <div class="card-body">
                <div class="tw-flex tw-items-center tw-justify-center">
                    <img src="/assets/images/logo.png" alt="site logo" class="light-logo tw-h-20">
                </div>
                <h6 class="mb-4 text-xl">Install LaundryBox</h6>
                <p class="text-neutral-500">Fill up your details and proceed next steps.</p>
                @if ($step != 5)
                <!-- Form Wizard Start -->
                <div class="form-wizard">
                    <div class="form-wizard-header overflow-x-auto scroll-sm pb-8 my-32">
                        <ul class="list-unstyled form-wizard-list">
                            <li class="form-wizard-list__item tw-w-full" :class="step == 1 ? 'active' : step > 1 ? 'activated' : ''">
                                <div class="form-wizard-list__line">
                                    <span class="count">1</span>
                                </div>
                                <span class="text text-xs fw-semibold">Requirements </span>
                            </li>
                            <li class="form-wizard-list__item tw-w-full "  :class="step == 2 ? 'active' : step > 2 ? 'activated' : ''">
                                <div class="form-wizard-list__line">
                                    <span class="count">2</span>
                                </div>
                                <span class="text text-xs fw-semibold">Verification</span>
                            </li>
                            <li class="form-wizard-list__item tw-w-full "  :class="step == 3 ? 'active' : step > 3 ? 'activated' : ''">
                                <div class="form-wizard-list__line">
                                    <span class="count">3</span>
                                </div>
                                <span class="text text-xs fw-semibold">Database</span>
                            </li>
                            <li class="form-wizard-list__item  tw-w-full" :class="step == 5 ? 'activated' : step > 5 ? 'activated' : ''">
                                <div class="form-wizard-list__line">
                                    <span class="count">4</span>
                                </div>
                                <span class="text text-xs fw-semibold">Completed</span>
                            </li>
                        </ul>
                    </div>
                    
                    <template x-if="step == 1">
                        <div class="wizard-fieldset show">
                            <div class="row gy-1 ">
                                <h6 class="text-md text-neutral-500 tw-font-bold">Extensions</h6>
                                @if ($extensions)
                                    @foreach ($extensions as $key => $row)
                                        <div class="tw-flex tw-justify-between tw-items-center  tw-text-neutral-600 ">
                                            <div class="tw-text-neutral-600 tw-text-xs">{{ $key }}</div>
                                            <div class="">
                                                @if ($row == 1)
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="tw-size-6  tw-text-green-500">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="tw-size-6 tw-text-red-500">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <h6 class="text-md text-neutral-500 tw-mt-4 tw-font-bold">Directories</h6>
                                @if ($directories)
                                    @foreach ($directories as $key => $row)
                                        <div class="tw-flex tw-justify-between tw-items-center  tw-text-neutral-600 ">
                                            <div class="tw-text-neutral-600 tw-text-xs">{{ $key }}</div>
                                            <div class="">
                                                @if ($row == 1)
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="tw-size-6  tw-text-green-500">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="tw-size-6 tw-text-red-500">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            
                                <template x-if="requirementSatisfied !== true">
                                    <p class="text-danger text-center text-xs text-red-500">{{ __('installer.cannot_proceed') }}</p>
                                </template>
                                <template x-if="requirementSatisfied === true">
                                    <div class="d-flex w-100  justify-content-end pt-8  pb-4  ">
                                        <button class="form-wizard-next-btn btn btn-primary-600 px-32"
                                            @click.prevent="showDatabase">{{__('installer.next')}}</button>
                                    </div>
                                </template>
                            </div>
                        </div>	
                    </template>
                    
                    <template x-if="step == 2">
                        <div class="wizard-fieldset show ">
                            <div class="row gy-2 ">
                                <h6 class="text-md text-neutral-500 tw-font-bold">Verify License</h6>
                                <div class="">
                                    <label for="database_host"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        Username <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" required autofocus class="form-control radius-8" id="database_host"
                                        placeholder="Username"
                                        wire:model="client_name">
                                        @error('client_name')
                                            <span class="tw-text-xs tw-text-red-500">{{ $message }}</span>
                                            @enderror
                                </div>
                                        
                                <div class="">
                                    <label for="database_host"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        License Code <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" required autofocus class="form-control radius-8" id="database_host"
                                        placeholder="Enter License Code"
                                        wire:model="license_code">
                                        @error('license_code')
                                            <span class="tw-text-xs tw-text-red-500">{{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="w-full">
                                    <span class="tw-text-xs tw-text-red-500 tw-text-center">{{ $errormessage }}</span>
                                </div>
                                <div class="d-flex w-100  justify-content-end pt-8  pb-4  ">
                                    <button class="form-wizard-next-btn btn btn-primary-600 px-32 tw-flex tw-items-center tw-gap-2"
                                        @click.prevent="checkLicense">
                                        {{__('installer.next')}}
                                        <div class="spinner-border tw-size-3" role="status" wire:loading="checkLicense">
                                            <span class="visually-hidden">Loading...</span>
                                            </div>
                                    </button>
                                </div>
                                </template>
                            </div>
                        </div>	
                    </template>


                    <template x-if="step == 3">
                        <div class="wizard-fieldset show 3 tw-p-5 tw-pt-0">
                            <div class="row gy-2 ">
                                <h6 class="text-md text-neutral-500 tw-font-bold">Database</h6>
                                <div class="">
                                    <label for="database_host"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        {{ __('installer.database_host') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" required autofocus class="form-control radius-8" id="database_host"
                                        placeholder="{{ __('installer.database_host') }}"
                                        wire:model="host">
                                        @error('host')
                                        <span class="tw-text-xs tw-text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="">
                                    <label for="database_port"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        {{ __('installer.database_port') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" required autofocus class="form-control radius-8" id="database_port"
                                        placeholder="{{ __('installer.database_port') }}"
                                        wire:model="port">
                                        @error('port')
                                        <span class="tw-text-xs tw-text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="">
                                    <label for="database_name"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        {{ __('installer.database_name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" required autofocus class="form-control radius-8" id="database_name"
                                        placeholder="{{ __('installer.database_name') }}"
                                        wire:model="name">
                                        @error('name')
                                            <span class="tw-text-xs tw-text-red-500">{{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="">
                                    <label for="database_username"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        {{ __('installer.database_username') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" required autofocus class="form-control radius-8" id="database_username"
                                        placeholder="{{ __('installer.database_username') }}"
                                        wire:model="username">
                                        @error('username')
                                            <span class="tw-text-xs tw-text-red-500">{{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="">
                                    <label for="password"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        {{ __('installer.database_password') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" required autofocus class="form-control radius-8" id="password"
                                        placeholder="{{ __('installer.database_password') }}"
                                        wire:model="password">
                                        @error('password')
                                        <span class="tw-text-xs tw-text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <span class="tw-text-xs tw-text-red-500 tw-text-center">{{ $errormessage }}</span>
                                </div>
                                <div class="d-flex w-100  justify-content-end pt-8  pb-4  ">
                                        <button class="form-wizard-next-btn btn btn-primary-600 px-32"
                                            @click.prevent="checkDatabase">{{__('installer.next')}}</button>
                                    </div>
                            </div>
                        </div>	
                    </template>


                    <template x-if="step == 4">
                        <div class="wizard-fieldset show tw-p-5 tw-pt-0">
                            <div class="row gy-2 ">
                                <h6 class="text-md text-neutral-500 tw-font-bold">Installing</h6>
                            </div>
                            <div class="progress tw-mt-2 h-8-px w-100 bg-primary-50" role="progressbar" aria-label="Basic example" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-striped progress-bar-animated rounded-pill bg-primary-600" style="width: 100%"></div>                    
                            </div>
                        </div>	
                    </template>
                </div>
                <!-- Form Wizard End -->
                @else
                <!-- Form Wizard Start -->
                <div class="form-wizard">
                    <form action="#" method="post">
                        <div class="form-wizard-header overflow-x-auto scroll-sm pb-8 my-32">
                            <ul class="list-unstyled form-wizard-list">
                                <li class="form-wizard-list__item tw-w-full" :class="step == 1 ? 'active' : step > 1 ? 'activated' : ''">
                                    <div class="form-wizard-list__line">
                                        <span class="count">1</span>
                                    </div>
                                    <span class="text text-xs fw-semibold">Requirements </span>
                                </li>
                                <li class="form-wizard-list__item tw-w-full "  :class="step == 2 ? 'active' : step > 2 ? 'activated' : ''">
                                    <div class="form-wizard-list__line">
                                        <span class="count">2</span>
                                    </div>
                                    <span class="text text-xs fw-semibold">Verification</span>
                                </li>
                                <li class="form-wizard-list__item tw-w-full "  :class="step == 3 ? 'active' : step > 3 ? 'activated' : ''">
                                    <div class="form-wizard-list__line">
                                        <span class="count">3</span>
                                    </div>
                                    <span class="text text-xs fw-semibold">Database</span>
                                </li>
                                <li class="form-wizard-list__item  tw-w-full" :class="step == 4 ? 'activated' : step > 4 ? 'activated' : ''">
                                    <div class="form-wizard-list__line">
                                        <span class="count">4</span>
                                    </div>
                                    <span class="text text-xs fw-semibold">Completed</span>
                                </li>
                            </ul>
                        </div>
                        <div class="wizard-fieldset show tw-p-5 tw-pt-0">
                            <div class="row gy-2 ">
                                <div class="text-neutral-600">{{__('installer.your_email_is')}} </div>
                                <div class="text-neutral-600 pt-2">{{__('installer.your_password_is')}} </div>
                            </div>
                            <a href="{{route('login')}}" @click.prevent="goLogin()" type="button" class="btn btn-primary radius-8 px-20 py-11 d-flex align-items-center gap-2 tw-mt-2 tw-w-fit"> 
                                Login <iconify-icon icon="mingcute:square-arrow-right-line" class="text-xl"></iconify-icon> 
                            </a>
                        </div>	
                    </form>
                </div>
                <!-- Form Wizard End -->
                @endif  
            </div>
        </div>
    
    </div>
 
    <script>
        function alpineInstaller()
        {
            'use strict'
            return{
                step : 1,
                loadingLicenseCheck : false,
                loading : true,
                requirementSatisfied : this.$wire.entangle('requirement_satisfied'),
                init()
                {
                    this.checkRequirements()
                },
                checkRequirements()
                {
                    this.$wire.checkRequirementsServer(1).then(result => {
                        this.step = 1;
                    })
                },
                checkLicense(){
                    this.$wire.checkLicense(1).then(result => {
                        if(result === true){
                            this.step = 3;
                        }
                    })
                },
                showDatabase()
                {
                    this.$wire.hasLocal().then((result) => {
                        if(result === true){
                            this.step = 3;
                        }
                        else{
                            this.step = 2;
                        }
                    })
                },
                checkDatabase()
                {
                    this.loading = true;
                    this.$wire.checkDatabase(1).then(result => {
                        if(result == true)
                        {
                            this.startInstallation()
                        }
                        else{
                            this.loading = false;
                        }
                    })
                },
                goLogin(){
                    window.location.href= window.location.origin
                },
                startInstallation()
                {
                    this.$wire.startInstallation(1).then(result => {
                        this.step = 5;
                        this.loading = false;
                    })
                }
            }
        }
    </script>
</div>