@php
    $isLoggedIn = Auth::check();
@endphp
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Page Title' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    @stack('lottie-head')
    @stack('aos-head')
</head>

<body>
<flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2"/>
    <flux:brand href="/" name="{{ env('APP_NAME') }}" class="max-lg:hidden"/>
    <flux:spacer/>
    <flux:navbar class="-mb-px max-lg:hidden">
        <flux:navbar.item icon="home" href="/">Home</flux:navbar.item>
        <flux:navbar.item icon="user-group" href="/internship">Internship</flux:navbar.item>
    </flux:navbar>
    <flux:spacer/>
    @if($isLoggedIn)
        <flux:dropdown position="top" align="start">
            <flux:profile :chevron="false" avatar:name="{{ ucfirst(strtolower(Auth::user()->name)) }}"/>
            <flux:menu>
                <flux:navlist.group class="px-3 py-1">
                    <flux:heading>{{ ucfirst(strtolower(Auth::user()->name)) }}</flux:heading>
                    <flux:text>{{ Auth::user()->email }}</flux:text>
                </flux:navlist.group>
                <flux:menu.separator/>
                <flux:navlist.item href="/settings" icon="cog-6-tooth">Settings</flux:navlist.item>
                <flux:menu.separator/>
                <form method="POST" wire:submit.prevent action="{{ route('logout') }}">
                    @csrf
                    <flux:navlist.item type="submit" icon="arrow-right-start-on-rectangle">Logout</flux:navlist.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    @endif
    <div class="flex gap-4">
        @if(!$isLoggedIn)
            <flux:button href="{{ route('login') }}" variant="primary">Login</flux:button>
        @endif
        <flux:dropdown x-data align="end">
            <flux:button variant="subtle" square class="group" aria-label="Preferred color scheme">
                <flux:icon.sun x-show="$flux.appearance === 'light'" variant="mini" class="text-zinc-500 dark:text-white"/>
                <flux:icon.moon x-show="$flux.appearance === 'dark'" variant="mini" class="text-zinc-500 dark:text-white"/>
                <flux:icon.computer-desktop x-show="$flux.appearance === 'system' && $flux.dark" variant="mini"/>
                <flux:icon.computer-desktop x-show="$flux.appearance === 'system' && ! $flux.dark" variant="mini"/>
            </flux:button>

            <flux:menu>
                <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">Light</flux:menu.item>
                <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">Dark</flux:menu.item>
                <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'">System</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </div>
</flux:header>
<flux:sidebar stashable sticky
              class="border-r border-zinc-200 bg-zinc-50 lg:hidden rtl:border-l rtl:border-r-0 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>
    <flux:brand href="/" name="{{ env('APP_NAME') }}" class="px-2 dark:hidden"/>
    <flux:brand href="/" name="{{ env('APP_NAME') }}" class="hidden px-2 dark:flex"/>
    <flux:navlist variant="outline" class="space-y-2!">
        <flux:navlist.item icon="home" href="/">Home</flux:navlist.item>
        <flux:navlist.item icon="user-group" href="/internship">Internship</flux:navlist.item>
    </flux:navlist>
    <flux:spacer/>
    <flux:navlist variant="outline">
        <flux:navlist.item icon="cog-6-tooth" href="#">Settings</flux:navlist.item>
        <flux:navlist.item icon="information-circle" href="#">Help</flux:navlist.item>
    </flux:navlist>
</flux:sidebar>

<flux:main>
    {{ $slot }}
</flux:main>

@fluxScripts
@stack('lottie-script')
@stack('aos-script')
<script src="https://unpkg.com/typeit@8.8.7/dist/index.umd.js"></script>
</body>
</html>
