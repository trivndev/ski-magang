<div class="flex justify-center items-center min-h-svh">
    <div
        class="bg-background flex h-full gap-6 sm:border lg:w-2/3 lg:max-w-4xl lg:border-gray-200 dark:lg:border-gray-700 shadow-none dark:shadow-none mx-auto rounded-xl overflow-hidden sm:shadow-sm p-2">
        <div class="w-full hidden lg:block aspect-square" wire:ignore>
            <div
                class="flex-1 h-full aspect-square w-full rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 dark:from-gray-800 dark:to-gray-900 p-6 hidden lg:flex">
                <div class="text-white flex flex-col justify-center items-center w-full">
                    <div>
                        <canvas id="email-verify" class="min-size-96 w-full"></canvas>
                        @vite('resources/js/lottie.js')
                        <script type="module">
                            (function () {
                                try {
                                    if (typeof window.initDotLottie !== 'function') {
                                        throw new Error('initDotLottie is not available');
                                    }
                                    window.initDotLottie({
                                        id: 'email-verify',
                                        src: "{{ asset('lotties/email-verification.lottie') }}",
                                        autoplay: true,
                                        loop: true,
                                    });
                                } catch (e) {
                                    console.error('Failed to initialize Lottie:', e);
                                }
                            })();
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:max-w-md flex sm:min-w-sm lg:min-w-0 w-full flex-col gap-4 justify-center p-8 md:p-10">
            <h1 class="text-center font-semibold text-3xl">Verify your email</h1>
            <div class="flex flex-col gap-6">
                <flux:text class="text-center">
                    {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
                </flux:text>

                @if (session('status') == 'verification-link-sent')
                    <flux:text class="text-center font-medium !dark:text-green-400 !text-green-600">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </flux:text>
                @endif

                @php($authed = auth()->check())
                @if($authed && auth()->user()->hasVerifiedEmail())
                    <flux:text class="text-center font-medium !dark:text-green-400 !text-green-600">
                        {{ __('Your email address is already verified.') }}
                    </flux:text>
                    <div class="flex flex-col items-center justify-between space-y-3">
                        <flux:link :href="route('home')" wire:navigate>
                            <flux:button variant="primary" class="w-full">{{ __('Go to Home') }}</flux:button>
                        </flux:link>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-between space-y-3">
                        <flux:button wire:click="sendVerification" variant="primary" class="w-full">
                            {{ __('Resend verification email') }}
                        </flux:button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
