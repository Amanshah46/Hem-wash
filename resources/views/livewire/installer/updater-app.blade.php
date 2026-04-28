<div class="tw-flex tw-justify-center tw-items-center tw-h-screen tw-w-full tw-overflow-auto py-32" x-data="alpineInstaller">
    <div class=" tw-flex tw-items-center tw-justify-center">
        <div class="card tw-w-[30%] tw-min-w-[36rem]  ">
            <div class="card-body">
                <div class="tw-flex tw-items-center tw-justify-center">
                    <img src="/assets/images/logo.png" alt="site logo" class="light-logo tw-h-20">
                </div>
                <template x-if="!running">
                    <div class="tw-w-full tw-flex tw-flex-col tw-py-8 tw-pt-0">
                        <div class="tw-w-full tw-flex tw-items-center tw-justify-center tw-flex-col">
                            <h6 class="mb-4 text-xl">Install LaundryBox</h6>
                            <p class="text-neutral-500">We found an update, Press continue to install it.</p>
                        </div>
                     
                        @if(!$hasLicense)
                        <div class="tw-mt-6">
                            <label for="username"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Username <span class="text-danger">*</span>
                            </label>
                            <input type="text" required autofocus class="form-control radius-8" id="username"
                                placeholder="Username"
                                wire:model="client_name">
                                @if(isset($errors))
                                @error('client_name')
                                    <span class="tw-text-xs tw-text-red-500">{{ $message }}</span>
                                @enderror
                                @endif
                        </div>
                        <div class="tw-mt-2">
                            <label for="license_code"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">
                                License Code <span class="text-danger">*</span>
                            </label>
                            <input type="text" required autofocus class="form-control radius-8" id="license_code"
                                placeholder="Enter License Code"
                                wire:model="license_code">
                                @if(isset($errors))
                                @error('license_code')
                                    <span class="tw-text-xs tw-text-red-500">{{ $message }}</span>
                                @enderror
                                @endif
                        </div>
                        @endif
                    </div>
                </template>
                <template x-if="running">
                <div class="tw-w-full tw-flex tw-items-center tw-justify-center tw-flex-col tw-py-24 tw-px-10 tw-pt-14">
                    <h6 class="mb-4 text-xl">Updating...</h6>
                    <div class="progress tw-mt-2 h-8-px w-100 bg-primary-50" role="progressbar" aria-label="Basic example" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-striped progress-bar-animated rounded-pill bg-primary-600" style="width: 100%"></div>                    
                    </div>
                </div>
                </template>
            
                <!-- Form Wizard Start -->
                <div class="form-wizard ">
                    <form action="#" method="post">
                        <div class="d-flex w-100  justify-content-end pt-0  pb-4  ">
                            <button class="form-wizard-next-btn btn btn-primary-600 px-32" @click.prevent="updateApp" :disabled="running">
                                {{__('installer.next')}}
                                <div class="spinner-border tw-size-3" role="status" wire:loading="updateApp">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
    </div>
 
    <script>
        function alpineInstaller()
        {
            'use strict'
            return{
                step : 1,
                running : false,
                init()
                {

                },
                async updateApp(){
                    await this.$wire.doChecks().then(async (res) => {
                        if(res == true){
                            this.running = true;
                            this.$wire.updateApp().then((ress) => {
                                window.location.href = ("{{route('login')}}")
                            })
                        }
                    })
                   
                }
            
            }
        }
    </script>
</div>