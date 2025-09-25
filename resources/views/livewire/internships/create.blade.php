<div class="flex flex-col space-y-4 mx-auto max-w-7xl py-8 px-4 md:py-16">
    <div class="flex justify-between">
        <form class="hidden md:block">
            <div class="flex gap-3 items-center">
                <flux:input placeholder="Search post" icon="magnifying-glass" class="max-w-xs"/>
                <flux:button variant="primary">Search</flux:button>
            </div>
        </form>
        <flux:modal name="hi">
            Filter
        </flux:modal>
        <flux:modal.trigger name="hi" class="flex md:hidden">
            <flux:button icon="adjustments-horizontal" variant="primary">
                Filter
            </flux:button>
        </flux:modal.trigger>
        <flux:modal.trigger name="hi" class="hidden md:flex">
            <flux:button icon="adjustments-horizontal" variant="primary"/>
        </flux:modal.trigger>
    </div>
    <div>

    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-6 md:gap-8">
        @foreach($this->internships as $internship)
            <x-internship.card :$internship/>
        @endforeach
    </div>
</div>
