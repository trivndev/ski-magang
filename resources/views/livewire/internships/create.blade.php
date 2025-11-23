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
<div class="space-x-12 space-y-8 mx-auto max-w-7xl py-8 px-8 md:py-16">
    <div class="space-y-4 w-full">
        <div>
            <flux:heading class="text-xl">
                Add New Post
            </flux:heading>
            @if(session('success'))
                {{ session('success') }}
            @endif
        </div>
        <x-internship.filter-search :selectMode="$selectMode" :hasItems="$internships->count() > 0"
                                    :isCreatePage="true"/>
    </div>
    <div data-aos="fade-up" data-aos-duration="500" data-aos-once="true" data-aos-anchor-placement="top-bottom"
         class="space-y-8" wire:ignore.self>
        <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-6 md:gap-8">
            @foreach($internships as $internship)
                <div class="relative" x-data>
                    @if($selectMode)
                        <div
                            class="absolute -top-3 -left-3 z-20 rounded-md bg-white/90 dark:bg-gray-900/90 ring-2 ring-blue-500 shadow p-1"
                            x-on:click.stop>
                            <flux:checkbox wire:model="selected" value="{{ $internship->id }}"
                                           wire:key="select-{{ $internship->id }}-{{ in_array($internship->id, $selected ?? []) ? '1' : '0' }}"/>
                        </div>
                    @endif
                    <x-internship.card :$internship :is-create-route="true"/>
                </div>
            @endforeach
        </div>
        {{ $internships->links() }}
        <x-internship.bulk-select-toolbar
            :selectMode="$selectMode"
            :selectedCount="count($selected)"
            :idsJson="json_encode($internships->pluck('id')->toArray())"
            :hasItems="$internships->count() > 0"
            mainActionMethod="bulkDelete"
            mainActionLabel="Delete selected"
        />
    </div>
</div>
