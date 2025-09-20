<div class="flex justify-center items-center min-h-svh">
    <div
        class="bg-background flex h-full gap-6 sm:border lg:w-2/3 lg:max-w-4xl lg:border-gray-200 dark:lg:border-gray-700 shadow-none dark:shadow-none mx-auto rounded-xl overflow-hidden sm:shadow-sm p-2">
        <x-auth-lottie/>
        <div class="lg:max-w-md flex sm:min-w-sm lg:min-w-0 w-full flex-col gap-4 justify-center p-8 md:p-10">
            <h1 class="text-center font-semibold text-3xl">Welcome Back!</h1>
            <div>
                <x-auth-session-status class="text-center" :status="session('status')"/>
                <form wire:submit="login" class="flex flex-col gap-6">
                    <flux:input
                        wire:model="email"
                        :label="__('Email address')"
                        type="email"
                        autofocus
                        autocomplete="email"
                        placeholder="email@example.com"
                    />

                    <div class="relative">
                        <flux:input
                            wire:model="password"
                            :label="__('Password')"
                            type="password"
                            autocomplete="current-password"
                            :placeholder="__('Password')"
                            viewable
                        />

                        @if (Route::has('password.request'))
                            <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')"
                                       wire:navigate>
                                {{ __('Forgot your password?') }}
                            </flux:link>
                        @endif
                    </div>

                    <flux:checkbox wire:model="remember" :label="__('Remember me')"/>

                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
                    </div>
                </form>

                @if (Route::has('register'))
                    <div
                        class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400 mt-2">
                        <span>{{ __('Don\'t have an account?') }}</span>
                        <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
