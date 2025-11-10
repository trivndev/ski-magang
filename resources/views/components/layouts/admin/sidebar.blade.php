<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Page Title' }}</title>
    @vite(['resources/css/app.css'])
    @fluxAppearance
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
<flux:sidebar sticky collapsible class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.header class="flex! items-center!">
        <flux:sidebar.brand class="gap-0!" href="{{ route('admin.dashboard') }}" name="{{ config('app.name') }}">
            <x-slot name="logo" class="w-0! min-w-0!">
            </x-slot>
        </flux:sidebar.brand>
        <flux:sidebar.collapse
            class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2 opacity-100!"/>
    </flux:sidebar.header>
    <flux:sidebar.nav>
        <flux:sidebar.item href="{{ route('admin.dashboard') }}">
            Dashboard
        </flux:sidebar.item>
        <flux:sidebar.item href="">
            Users List
        </flux:sidebar.item>
        <flux:sidebar.item>
            Posts List
        </flux:sidebar.item>
    </flux:sidebar.nav>
    <flux:sidebar.spacer/>
    <flux:sidebar.nav>
        <flux:modal.trigger name="settings">
            <flux:sidebar.item icon="cog-6-tooth">Settings</flux:sidebar.item>
        </flux:modal.trigger>
        <flux:modal name="settings" class="max-w-[90%] w-full sm:max-w-lg outline-none">
        </flux:modal>
    </flux:sidebar.nav>
    <flux:dropdown position="top" align="start" class="max-lg:hidden">
        <flux:profile :chevron="false" avatar:name="{{ ucfirst(strtolower(Auth::user()->name)) }}"
                      name="{{Auth::user()->name}}"/>
        <flux:menu>
            <flux:menu.radio.group>
                <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                <flux:menu.radio>Truly Delta</flux:menu.radio>
            </flux:menu.radio.group>
            <flux:menu.separator/>
            <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
        </flux:menu>
    </flux:dropdown>
</flux:sidebar>
<flux:header class="lg:hidden">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left"/>
    <flux:spacer/>
    <flux:dropdown position="top" align="start">
        <flux:profile :chevron="false" avatar:name="{{ ucfirst(strtolower(Auth::user()->name)) }}"
                      name="{{Auth::user()->name}}"/>
        <flux:menu>
            <flux:sidebar.item icon="arrow-left-start-on-rectangle">
                Exit Admin
            </flux:sidebar.item>
            <flux:menu.separator/>
            <form method="POST" wire:submit.prevent action="{{ route('logout') }}">
                @csrf
                <flux:navlist.item type="submit" icon="arrow-right-start-on-rectangle">Logout
                </flux:navlist.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:header>

<flux:main>
    {{ $slot }}
</flux:main>
<x-penguin-ui.toast/>

@fluxScripts
</body>

</html>
