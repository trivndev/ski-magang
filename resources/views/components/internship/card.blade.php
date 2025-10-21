@props(['internship' => null, 'isCreateRoute' => false])
@php
    use Carbon\Carbon;
@endphp
<div wire:key="internship-card-{{ $internship->id }}">
    <flux:modal.trigger name="internship-{{ $internship->id }}" wire:key="trigger-{{ $internship->id }}">
        <div
            class="p-6 block rounded-lg shadow outline outline-gray-100 dark:outline-gray-500 hover:outline-blue-500 transition-colors duration-300 cursor-pointer dark:shadow-none overflow-hidden bg-white/30 backdrop-blur-md dark:bg-gray-900/30 h-full">
            <div class="flex flex-col justify-between h-full space-y-2">
                <div class="space-y-1">
                    @if($isCreateRoute)
                        <div class="flex items-center justify-between">
                            <div>
                                @php($statusLabel = optional($internship->status)->status)
                                @switch($statusLabel)
                                    @case('Pending')
                                        <flux:badge color="zinc">Pending</flux:badge>
                                        @break
                                    @case('Approved')
                                        <flux:badge color="green">Approved</flux:badge>
                                        @break
                                    @case('Rejected')
                                        <flux:badge color="red">Rejected</flux:badge>
                                        @break
                                    @default
                                        @if($statusLabel)
                                            <flux:badge color="zinc">{{ $statusLabel }}</flux:badge>
                                        @endif
                                @endswitch
                            </div>
                            <div class="flex items-center space-x-2 sm:ml-auto w-fit order-2">
                                <div class="flex items-center space-x-1">
                                    <flux:icon.academic-cap variant="solid" class="text-blue-500"/>
                                    <flux:text>{{ $internship->vocationalMajor->major_name }}</flux:text>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <flux:icon.heart variant="solid" class="text-red-500"/>
                                    <flux:text>{{ $internship->likes_count }}</flux:text>
                                </div>
                            </div>
                        </div>
                    @endif
                    <h1 class="text-lg md:text-xl font-medium">{{ $internship->job_title }}</h1>
                    <h2 class="md:text-lg">{{ $internship->company }}</h2>
                    <p class="text-sm md:text-base">{{ $internship->location }}</p>
                    <div class="flex sm:block justify-between items-center space-y-1">
                        @if(!$isCreateRoute)
                            <div class="flex items-center space-x-2 sm:ml-auto w-fit order-2">
                                <div class="flex items-center space-x-1">
                                    <flux:icon.academic-cap variant="solid" class="text-blue-500"/>
                                    <flux:text>{{ $internship->vocationalMajor->major_name }}</flux:text>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <flux:icon.heart variant="solid" class="text-red-500"/>
                                    <flux:text>{{ $internship->likes_count }}</flux:text>
                                </div>
                            </div>
                        @endif
                        <div class="sm:flex items-center justify-between sm:space-x-2">
                            <flux:text>Posted {{ $internship->created_at->diffForHumans() }}</flux:text>
                            <flux:text>Closes
                                on {{ Carbon::parse($internship->end_date)->format("D, d M Y") }}</flux:text>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </flux:modal.trigger>

    <flux:modal name="internship-{{ $internship->id }}" class="max-w-[90%] w-full sm:max-w-lg outline-none"
                wire:key="modal-{{ $internship->id }}"
                :dismissible="false">
        <div class="space-y-3">
            <div>
                <flux:heading class="text-xl">Internship Details</flux:heading>
            </div>
            <flux:separator/>
            <div>
                <h1 class="text-base md:text-lg">
                    {{ $internship->job_title }}
                </h1>
                <flux:text class="text-base md:text-lg">
                    {{ $internship->company }}
                </flux:text>
                <div class="space-y-1">
                    <div class="flex items-center space-x-2 place-items-center">
                        <flux:icon.map-pin variant="solid" class="text-red-500"/>
                        <flux:text>{{ $internship->location }}</flux:text>
                    </div>
                    <div class="flex items-center space-x-2 place-items-center">
                        <flux:icon.academic-cap variant="solid" class="text-blue-500"/>
                        <flux:text>{{ $internship->vocationalMajor->major_name }}</flux:text>
                    </div>
                    <div class="flex items-center space-x-2 place-items-center">
                        <flux:icon.phone variant="solid" class="text-green-500"/>
                        <flux:text>{{ "$internship->contact_phone ($internship->contact_name)" }}</flux:text>
                    </div>
                    <div class="flex items-center space-x-2 place-items-center">
                        <flux:icon.heart variant="solid" class="text-red-500"/>
                        <flux:text>{{ $internship->likes_count }} People like this post</flux:text>
                    </div>
                    <div class="flex items-center space-x-2 place-items-center">
                        <flux:icon.calendar-days variant="solid"/>
                        <flux:text>Until {{ Carbon::parse($internship->end_date)->format("l, d M Y") }} </flux:text>
                    </div>
                </div>
            </div>
            <div class="flex gap-x-4 gap-y-2 flex-wrap">
                @if($internship->bookmarked_by_me)
                    <flux:tooltip content="Unsave this post">
                        <flux:button variant="primary" icon="bookmark" icon:variant="solid"
                                     wire:click.stop="toggleBookmark('{{ $internship->getKey() }}')"
                                     wire:loading.class="pointer-events-none animate-pulse"
                                     wire:target="toggleBookmark"/>
                    </flux:tooltip>
                @else
                    <flux:tooltip content="Save this post">
                        <flux:button variant="primary" icon="bookmark" icon:variant="outline"
                                     wire:click.stop="toggleBookmark('{{ $internship->getKey() }}')"
                                     wire:loading.class="pointer-events-none animate-pulse"
                                     wire:target="toggleBookmark"/>
                    </flux:tooltip>
                @endif
                @if($internship->liked_by_me)
                    <flux:tooltip content="Remove like">
                        <flux:button icon="heart" variant="primary" color="red" icon:variant="solid"
                                     class="hidden md:flex" wire:click.stop="toggleLike('{{ $internship->getKey() }}')"
                                     wire:loading.class="pointer-events-none animate-pulse"
                                     wire:target="toggleLike"/>
                    </flux:tooltip>
                @else
                    <flux:tooltip content="Like this post">
                        <flux:button icon="heart" variant="primary" color="red" icon:variant="outline"
                                     wire:click.stop="toggleLike('{{ $internship->getKey() }}')"
                                     wire:loading.class="pointer-events-none animate-pulse" wire:target="toggleLike"/>
                    </flux:tooltip>
                @endif
                <flux:modal.trigger name="share-internship-{{ $internship->id }}">
                    <flux:tooltip content="Share this post">
                        <flux:button icon="share" color="zinc" variant="primary" icon:variant="outline"/>
                    </flux:tooltip>
                </flux:modal.trigger>
            </div>
            <div class="space-y-2 [&_div]:space-y-1">
                <div>
                    <flux:heading size="lg">Job Description</flux:heading>
                    <flux:text>
                        {{ $internship->job_description }}
                    </flux:text>
                </div>
                <div>
                    <flux:heading size="lg">Requirements</flux:heading>
                    <flux:text>
                        {{ $internship->requirements }}
                    </flux:text>
                </div>
                @if($internship->benefits)
                    <div>
                        <flux:heading size="lg">Benefits</flux:heading>
                        <flux:text>
                            {{ $internship->benefits }}
                        </flux:text>
                    </div>
                @endif
            </div>
        </div>
    </flux:modal>
    <flux:modal class="max-w-[90%] w-full sm:max-w-lg outline-none" name="share-internship-{{ $internship->id }}">
        <div class="space-y-3">
            <div>
                <flux:heading class="text-xl">Internship Details</flux:heading>
            </div>
            <flux:separator/>
            <div>
                <flux:heading size="lg">
                    Share this post
                </flux:heading>
                <flux:input copyable="true" readonly="true"
                            value="{{ route('internships.index' ,$internship->getKey()) }}"/>
            </div>
        </div>
    </flux:modal>
</div>
