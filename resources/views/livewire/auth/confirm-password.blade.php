<div class="flex justify-center items-center min-h-svh">
    <div class="bg-background flex h-full gap-6 sm:border lg:w-2/3 lg:max-w-4xl lg:border-gray-200 dark:lg:border-gray-700 shadow-none dark:shadow-none mx-auto rounded-xl overflow-hidden sm:shadow-sm p-2">
        <x-auth-lottie/>
        <div class="lg:max-w-md flex sm:min-w-sm lg:min-w-0 w-full flex-col gap-4 justify-center p-8 md:p-10">
            <h1 class="text-center font-semibold text-3xl">Confirm your password</h1>
            <div>
                <x-auth-session-status class="text-center" :status="session('status')" />
                <form wire:submit="confirmPassword" class="flex flex-col gap-6">
                    <flux:input
                        wire:model="password"
                        :label="__('Password')"
                        type="password"
                        required
                        autocomplete="current-password"
                        :placeholder="__('Password')"
                        viewable
                    />
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Confirm') }}</flux:button>
                </form>
                <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400 mt-2">
                    <span>{{ __('Back to') }}</span>
                    <flux:link :href="route('home')" wire:navigate>{{ __('Home') }}</flux:link>
                </div>
            </div>
        </div>
    </div>
</div>
