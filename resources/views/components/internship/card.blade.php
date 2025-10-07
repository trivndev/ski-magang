@php
    use Carbon\Carbon;
@endphp
<div data-aos="fade-up" data-aos-duration="500" data-aos-once="true" data-aos-anchor-placement="top-bottom"
     wire:key="internship-card-{{ $internship->id }}">
    <flux:modal.trigger name="internship-{{ $internship->id }}" wire:key="trigger-{{ $internship->id }}">
        <div
            class="p-6 block rounded-lg shadow outline outline-gray-100 dark:outline-gray-500 hover:outline-blue-500 transition-colors duration-300 cursor-pointer dark:shadow-none overflow-hidden bg-white/30 backdrop-blur-md dark:bg-gray-900/30 h-full">
            <div class="flex flex-col justify-between h-full space-y-2">
                <div class="space-y-1">
                    <h1 class="text-lg md:text-xl font-medium">{{ $internship->job_title }}</h1>
                    <h2 class="md:text-lg">{{ $internship->company }}</h2>
                    <p class="text-sm md:text-base">{{ $internship->location }}</p>
                    <div>Posted {{ $internship->created_at->diffForHumans() }}, ended
                        in {{ Carbon::parse($internship->end_date)->diffForHumans() }}</div>
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
</div>
