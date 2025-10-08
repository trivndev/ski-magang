@php use App\Models\VocationalMajor; @endphp
@push('aos-head')
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
@endpush
@push('aos-script')
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            AOS.init({
                once: true,
                mirror: false,
            });

            Livewire.hook('morph.updated', () => {
                AOS.refreshHard();
            });
        });
    </script>
@endpush
<div class="space-x-12 space-y-8 mx-auto max-w-7xl py-8 px-4 md:py-16">
    <flux:heading class="text-xl">
        Bookmarked Posts
    </flux:heading>
    <div class="flex justify-between w-full">
        <form class="hidden md:block" wire:click.prevent="searchPost">
            <div class="flex gap-3 items-center">
                <flux:input placeholder="Search post" icon="magnifying-glass" class="max-w-xs"
                            wire:model="searchQuery"/>
                <flux:button variant="primary" type="submit">Search</flux:button>
            </div>
        </form>
        <flux:modal name="filter-posts" class="max-w-[90%] w-full sm:max-w-lg outline-none"
                    :dismissible="false">
            <div class="space-y-3">
                <div>
                    <flux:heading class="text-xl">Filter Posts</flux:heading>
                </div>
                <flux:separator/>
                <form class="space-y-6" wire:submit.prevent="applyFilters">
                    <div class="block md:hidden">
                        <div class="flex gap-3 items-center">
                            <flux:input wire:model="searchQuery" placeholder="Search post" icon="magnifying-glass"/>
                            <flux:button variant="primary">Search</flux:button>
                        </div>
                    </div>
                    <div>
                        <flux:label>
                            Sort By
                        </flux:label>
                        <flux:select placeholder="Default Newest" wire:model="sortBy">
                            <flux:select.option value="newest">Newest</flux:select.option>
                            <flux:select.option value="oldest">Oldest</flux:select.option>
                            <flux:select.option value="likes">Most liked</flux:select.option>
                        </flux:select>
                    </div>
                    <div>
                        <flux:checkbox.group label="Select Major" wire:model="selectedMajor">
                            @php
                                $vocationalMajors = VocationalMajor::all();
                            @endphp
                            @foreach($vocationalMajors as $vocationalMajor)
                                <flux:checkbox label="{{ $vocationalMajor->major_name }}"
                                               value="{{ $vocationalMajor->id }}"/>
                            @endforeach
                        </flux:checkbox.group>
                    </div>
                    <div class="justify-self-end space-x-1">
                        <flux:button variant="primary" color="red" wire:click="clearFilters">Reset</flux:button>
                        <flux:button variant="primary" wire:click="applyFilters">Apply</flux:button>
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
    <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-6 md:gap-8">
        @foreach($internships as $internship)
            <x-internship.card :$internship/>
        @endforeach
    </div>
    {{ $internships->links() }}
</div>
