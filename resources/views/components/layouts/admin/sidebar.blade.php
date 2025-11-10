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
    <flux:sidebar.header>
        <flux:sidebar.brand>
            {{ config('app.name') }}
        </flux:sidebar.brand>
        <flux:sidebar.collapse
            class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2"/>
    </flux:sidebar.header>
    <flux:sidebar.nav>
        <flux:sidebar.item icon="home" href="#" current>Home</flux:sidebar.item>
        <flux:sidebar.item icon="inbox" badge="12" href="#">Inbox</flux:sidebar.item>
        <flux:sidebar.item icon="document-text" href="#">Documents</flux:sidebar.item>
        <flux:sidebar.item icon="calendar" href="#">Calendar</flux:sidebar.item>
        <flux:sidebar.group expandable icon="star" heading="Favorites" class="grid">
            <flux:sidebar.item href="#">Marketing site</flux:sidebar.item>
            <flux:sidebar.item href="#">Android app</flux:sidebar.item>
            <flux:sidebar.item href="#">Brand guidelines</flux:sidebar.item>
        </flux:sidebar.group>
    </flux:sidebar.nav>
    <flux:sidebar.spacer/>
    <flux:sidebar.nav>
        <flux:sidebar.item icon="cog-6-tooth" href="#">Settings</flux:sidebar.item>
        <flux:dropdown align="end">
            <flux:sidebar.item
                x-data="{
                mode: $flux.appearance,
                init() {
                this.$watch('$flux.appearance', value => {
                this.mode = value
                console.log('appearance berubah ke:', value)
                })}}"
                icon="sun"
                aria-label="Preferred color scheme"
                class="group flex items-center gap-2"
            >
                <flux:text x-text="appearance">
                </flux:sidebar.item>

                <flux:menu>
                    <flux:menu.item icon="sun" @click="$flux.appearance = 'light'">Light</flux:menu.item>
                    <flux:menu.item icon="moon" @click="$flux.appearance = 'dark'">Dark</flux:menu.item>
                    <flux:menu.item icon="computer-desktop" @click="$flux.appearance = 'system'">System</flux:menu.item>
                </flux:menu>
            </flux:dropdown>

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
            <flux:profile avatar="/img/demo/user.png"/>
            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                    <flux:menu.radio>Truly Delta</flux:menu.radio>
                </flux:menu.radio.group>
                <flux:menu.separator/>
                <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
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
