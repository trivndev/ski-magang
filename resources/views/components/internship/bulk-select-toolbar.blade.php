@props([
    'selectMode' => false,
    'selectedCount' => 0,
    'idsJson' => '[]',
    'mainActionMethod' => null,
    'mainActionLabel' => '',
    'hasItems' => true,
])

@if($selectMode && $hasItems)
    <div class="fixed inset-x-0 bottom-6 sm:bottom-4 z-40" x-data="{ selected: @entangle('selected') }">
        <div class="mx-auto max-w-7xl px-8 pb-4">
            <div
                class="rounded-lg bg-white/70 dark:bg-gray-900/95 shadow-lg ring-1 ring-gray-200 dark:ring-gray-700 backdrop-blur-sm">
                <div class="flex flex-wrap items-center justify-between gap-3 px-4 py-3">
                    <div class="flex items-center gap-2">
                        <flux:button size="sm" variant="primary" color="zinc"
                                     x-on:click="selected.length ? $wire.set('selected', []) : $wire.set('selected', {{ $idsJson }})">
                            <span x-text="selected.length ? 'Deselect all' : 'Select all on page'"></span>
                        </flux:button>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($mainActionMethod)
                            <flux:button size="sm" variant="primary" color="red"
                                         wire:click="{{ $mainActionMethod }}"
                                         wire:loading.attr="disabled"
                                         wire:target="{{ $mainActionMethod }}"
                                         x-bind:disabled="selected.length === 0"
                            >
                                {{ $mainActionLabel }} (<span x-text="selected.length"></span>)
                            </flux:button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
