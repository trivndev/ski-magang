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

<body class="flex flex-col min-h-screen">
@php
    $isLoggedIn = Auth::check();
@endphp
<flux:header container
             class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 place-content-center top-0 z-50 sticky">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2"/>
    <flux:brand href="{{ route('home') }}" name="{{ config('app.name') }}" class="max-lg:hidden"/>
    <flux:spacer/>
    <flux:navbar class="-mb-px max-lg:hidden">
        <flux:navbar.item icon="home" :href="route('home')" :current="request()->routeIs('home')">Home
        </flux:navbar.item>
        <flux:navbar.item icon="user-group" href="{{ route('internships.index') }}"
                          :current="request()->routeIs('internships.index')">Internships
        </flux:navbar.item>
    </flux:navbar>
    <flux:spacer/>
    @if ($isLoggedIn)
        <flux:dropdown position="top" align="start">
            <flux:profile :chevron="false" avatar:name="{{ ucfirst(strtolower(Auth::user()->name)) }}"/>
            <flux:menu>
                <flux:navlist.group class="px-3 py-1">
                    <flux:heading>{{ ucfirst(strtolower(Auth::user()->name)) }}</flux:heading>
                    <flux:text>{{ Auth::user()->email }}</flux:text>
                </flux:navlist.group>
                <flux:menu.separator/>
                <flux:dropdown>
                    <flux:navmenu>
                        <flux:navlist.item href="{{ route('internships.create') }}"
                                           :current="request()->routeIs('internships.create')" icon="user-group">Posted
                            Internships
                        </flux:navlist.item>
                    </flux:navmenu>
                </flux:dropdown>
                <flux:navlist.item href="{{ route('internships.liked') }}"
                                   :current="request()->routeIs('internships.liked')" icon="heart">Liked Posts
                </flux:navlist.item>
                <flux:navlist.item href="{{ route('internships.bookmarked') }}"
                                   :current="request()->routeIs('internships.bookmarked')" icon="cog-6-tooth">Bookmarked
                    Posts
                </flux:navlist.item>
                <flux:menu.separator/>
                <flux:navlist.item href="/settings" icon="cog-6-tooth">Settings</flux:navlist.item>
                <form method="POST" wire:submit.prevent action="{{ route('logout') }}">
                    @csrf
                    <flux:navlist.item type="submit" icon="arrow-right-start-on-rectangle">Logout
                    </flux:navlist.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    @endif
    <div class="flex gap-4">
        @if (!$isLoggedIn)
            <flux:button href="{{ route('login') }}" variant="primary">Login</flux:button>
        @endif
        <flux:dropdown x-data align="end">
            <flux:button variant="subtle" square class="group" aria-label="Preferred color scheme">
                <flux:icon.sun x-show="$flux.appearance === 'light'" variant="mini"
                               class="text-zinc-500 dark:text-white"/>
                <flux:icon.moon x-show="$flux.appearance === 'dark'" variant="mini"
                                class="text-zinc-500 dark:text-white"/>
                <flux:icon.computer-desktop x-show="$flux.appearance === 'system' && $flux.dark" variant="mini"/>
                <flux:icon.computer-desktop x-show="$flux.appearance === 'system' && ! $flux.dark" variant="mini"/>
            </flux:button>

            <flux:menu>
                <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">Light</flux:menu.item>
                <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">Dark</flux:menu.item>
                <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'">System
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </div>
</flux:header>
<flux:sidebar stashable sticky
              class="border-r border-zinc-200 bg-zinc-50 lg:hidden rtl:border-l rtl:border-r-0 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>
    <flux:brand href="{{ route('home') }}" name="{{ config('app.name') }}" class="px-2 dark:hidden"/>
    <flux:brand href="{{ route('home') }}" name="{{ config('app.name') }}" class="hidden px-2 dark:flex"/>
    <flux:navlist variant="outline" class="space-y-2!">
        <flux:navlist.item icon="home" href="{{ route('home') }}" :current="request()->routeIs('home')">Home
        </flux:navlist.item>
        <flux:navlist.item icon="user-group" href="{{ route('internships.index') }}"
                           :current="request()->routeIs('internships.index')">Internships
        </flux:navlist.item>
    </flux:navlist>
    <flux:spacer/>
    <flux:navlist variant="outline">
        <flux:navlist.item icon="cog-6-tooth" href="#">Settings</flux:navlist.item>
        <flux:navlist.item icon="information-circle" href="#">Help</flux:navlist.item>
    </flux:navlist>
</flux:sidebar>

<main class="flex-1">
    {{ $slot }}
</main>

<flux:footer class="border-t border-gray-200 bg-white px-4 py-8 dark:border-gray-800 dark:bg-gray-950">
    <div class="mx-auto flex max-w-5xl flex-col items-center justify-between gap-4 md:flex-row">
        <div class="text-center text-gray-700 md:text-left dark:text-gray-300">
            &copy; {{ date('Y') }} SKI MAGANG. All rights reserved.
        </div>
        <div class="flex items-center gap-4">
            <a href="https://github.com/trivndev/ski-magang" target="_blank" rel="noopener"
               class="flex items-center text-gray-500 transition hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                     class="mr-1 h-5 w-5">
                    <path
                        d="M12 2C6.477 2 2 6.484 2 12.012c0 4.418 2.865 8.166 6.839 9.489.5.092.682-.217.682-.483 0-.237-.009-.868-.013-1.703-2.782.605-3.369-1.342-3.369-1.342-.454-1.155-1.11-1.463-1.11-1.463-.908-.62.069-.608.069-.608 1.004.07 1.532 1.032 1.532 1.032.892 1.529 2.341 1.088 2.91.833.091-.646.35-1.088.636-1.339-2.221-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.254-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.025A9.564 9.564 0 0 1 12 6.844c.85.004 1.705.115 2.504.337 1.909-1.295 2.748-1.025 2.748-1.025.546 1.378.202 2.396.099 2.65.64.7 1.028 1.595 1.028 2.688 0 3.847-2.337 4.695-4.566 4.944.359.309.678.919.678 1.852 0 1.336-.012 2.417-.012 2.747 0 .268.18.579.688.481C19.138 20.175 22 16.427 22 12.012 22 6.484 17.523 2 12 2z"/>
                </svg>
                <span>GitHub</span>
            </a>
            <a href=""
               class="flex items-center text-gray-500 transition hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     class="mr-1 h-5 w-5">
                    <rect x="3" y="7" width="18" height="10" rx="2" stroke-width="2"/>
                    <path d="M3 7l9 6 9-6" stroke-width="2"/>
                </svg>
                <span>Contact</span>
            </a>
        </div>
    </div>
</flux:footer>

<x-penguin-ui.toast/>
@fluxScripts
@stack('lottie-script')
@stack('aos-script')
</body>

</html>
