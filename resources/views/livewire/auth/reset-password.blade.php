<div class="flex justify-center items-center min-h-svh">
    <div
        class="bg-background flex h-full gap-6 sm:border lg:w-2/3 lg:max-w-4xl lg:border-gray-200 dark:lg:border-gray-700 shadow-none dark:shadow-none mx-auto rounded-xl overflow-hidden sm:shadow-sm p-2">
        <x-auth-lottie id="reset-password" src="{{ asset('lotties/reset-password.lottie') }}"/>
        <div class="lg:max-w-md flex sm:min-w-sm lg:min-w-0 w-full flex-col gap-4 justify-center p-8 md:p-10">
            <h1 class="text-center font-semibold text-3xl">Reset your password</h1>
            <div>
                <x-auth-session-status class="text-center" :status="session('status')"/>
                <form wire:submit="resetPassword" class="flex flex-col gap-6">
                    <flux:input
                        wire:model="email"
                        :label="__('Email address')"
                        type="email"
                        disabled
                        autocomplete="email"
                    />
                    <flux:input
                        wire:model="password"
                        :label="__('New password')"
                        type="password"
                        autocomplete="new-password"
                        :placeholder="__('Password')"
                        viewable
                    />
                    <flux:input
                        wire:model="password_confirmation"
                        :label="__('Confirm password')"
                        type="password"
                        autocomplete="new-password"
                        :placeholder="__('Confirm password')"
                        viewable
                    />
                    <div class="flex items-center justify-end">
                        <flux:button type="submit" variant="primary" class="w-full">
                            {{ __('Reset password') }}
                        </flux:button>
                    </div>
                </form>
                <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400 mt-2">
                    <span>{{ __('Back to') }}</span>
                    <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
                </div>
            </div>
        </div>
    </div>
</div>
