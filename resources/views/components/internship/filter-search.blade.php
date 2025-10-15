@php use App\Models\VocationalMajor; @endphp
<div class="flex w-full items-center gap-3 justify-between">
    <form class="hidden md:block" wire:submit.prevent="searchPost">
        <div class="flex gap-3 items-center">
            <flux:input placeholder="Search post" icon="magnifying-glass" class="max-w-xs"
                        wire:model.defer="draftSearchQuery"/>
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
                        <flux:input wire:model.defer="draftSearchQuery" placeholder="Search post"
                                    icon="magnifying-glass"/>
                        <flux:button variant="primary">Search</flux:button>
                    </div>
                </div>
                <div>
                    <flux:label>
                        Sort By
                    </flux:label>
                    <flux:select placeholder="Default Newest" wire:model.defer="draftSortBy">
                        <flux:select.option value="newest">Newest</flux:select.option>
                        <flux:select.option value="oldest">Oldest</flux:select.option>
                        <flux:select.option value="likes">Most liked</flux:select.option>
                    </flux:select>
                </div>
                <div>
                    <flux:checkbox.group label="Select Major" wire:model.defer="draftSelectedMajor">
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
    @if(!empty($isCreatePage))
        <x-internship.create-post-modal :$vocationalMajors/>
    @endif
    <div class="flex items-center gap-3 w-fit items-center">
        @if(isset($selectMode) && ($hasItems ?? true))
            <flux:button variant="primary" color="zinc" class="shrink-0" wire:click="$toggle('selectMode')">
                {{ ($selectMode ?? false) ? 'Done' : 'Select' }}
            </flux:button>
        @endif
        @if(!empty($isCreatePage))
            <flux:modal.trigger name="create-post">
                <flux:button icon="plus" color="zinc" variant="primary" class="shrink-0">
                    Create Post
                </flux:button>
            </flux:modal.trigger>
        @endif
        <flux:modal.trigger name="filter-posts" class="hidden md:flex">
            <flux:button icon="adjustments-horizontal" variant="primary">
                Filter
            </flux:button>
        </flux:modal.trigger>
        <flux:modal.trigger name="filter-posts" class="flex md:hidden">
            <flux:button icon="adjustments-horizontal" variant="primary"/>
        </flux:modal.trigger>
    </div>
</div>
