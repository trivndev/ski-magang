<div class="flex flex-col space-y-4 mx-auto max-w-7xl py-8 px-4 md:py-16">
    <div class="flex justify-between">
        <form class="hidden md:block">
            <div class="flex gap-3 items-center">
                <flux:input placeholder="Search post" icon="magnifying-glass" class="max-w-xs"/>
                <flux:button variant="primary">Search</flux:button>
            </div>
        </form>
        <flux:modal name="filter-posts" class="max-w-[90%] w-full sm:max-w-lg outline-none"
                    :dismissible="false">
            <div class="space-y-3">
                <div>
                    <flux:heading class="text-xl">Filter Posts</flux:heading>
                </div>
                <flux:separator/>
                <form class="space-y-6">
                    <div class="block md:hidden">
                        <form>
                            <div class="flex gap-3 items-center">
                                <flux:input placeholder="Search post" icon="magnifying-glass"/>
                                <flux:button variant="primary">Search</flux:button>
                            </div>
                        </form>
                    </div>
                    <div>
                        <flux:label>
                            Sort By
                        </flux:label>
                        <flux:select placeholder="Default Newest">
                            <flux:select.option>Newest</flux:select.option>
                            <flux:select.option>Oldest</flux:select.option>
                        </flux:select>
                    </div>
                    <div>
                        <flux:checkbox.group label="Select Major">
                            <flux:checkbox label="TKJ" value="tkj" checked/>
                            <flux:checkbox label="AKL" value="akl" checked/>
                            <flux:checkbox label="BID" value="bid" checked/>
                        </flux:checkbox.group>
                    </div>
                    <div class="justify-self-end space-x-1">
                        <flux:button variant="primary" color="red">Reset</flux:button>
                        <flux:button variant="primary">Apply</flux:button>
                    </div>
                </form>
            </div>
        </flux:modal>
        <flux:modal.trigger name="filter-posts" class="flex md:hidden">
            <flux:button icon="adjustments-horizontal" variant="primary">
                Filter
            </flux:button>
        </flux:modal.trigger>
        <flux:modal.trigger name="filter-posts" class="hidden md:flex">
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
