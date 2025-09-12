<div data-aos="fade-up" data-aos-duration="1000" data-aos-once="true" data-aos-anchor-placement="top-bottom">
    <div
        class="p-6 block rounded-lg shadow outline outline-gray-50 dark:outline-gray-500 hover:outline-blue-500 transition-colors duration-300 cursor-pointer dark:shadow-none overflow-hidden bg-white/30 backdrop-blur-md dark:bg-gray-900/30 h-full">
        <div class="flex flex-col justify-between h-full space-y-2">
            <div class="space-y-1">
                <h1 class="text-lg font-medium">{{ $internship->job_title }}</h1>
                <h2>{{ $internship->company }}</h2>
                <p class="text-sm">{{ $internship->location }}</p>
            </div>
            <div class="flex justify-between items-center text-sm">
                <div>Posted {{ $internship->created_at->diffForHumans() }}</div>
                <div class="flex">
                    <div>
                        <flux:dropdown>
                            <flux:button icon="ellipsis-vertical" variant="ghost"/>
                            <flux:menu>
                                <flux:modal.trigger name="internship-{{ $internship->id }}">
                                    <flux:menu.item icon="magnifying-glass" icon:variant="outline">See more
                                    </flux:menu.item>
                                </flux:modal.trigger>
                                @if($internship->likes->contains('user_id', auth()->id()))
                                    <flux:menu.item icon="heart" icon:variant="solid">Remove like</flux:menu.item>
                                @else
                                    <flux:menu.item icon="heart" icon:variant="outline">Like this post</flux:menu.item>
                                @endif
                                <flux:menu.item icon="bookmark" icon:variant="outline">Save this post</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                        <flux:modal name="internship-{{ $internship->id }}" class="max-w-[90%] w-full sm:max-w-lg"
                                    :dismissible="false">
                            <div class="space-y-3">
                                <div>
                                    <flux:heading size="lg">Internship Details</flux:heading>
                                </div>
                                <flux:separator/>
                                <div>
                                    <div>
                                        <flux:heading>
                                            {{ $internship->job_title }}
                                        </flux:heading>
                                        <flux:subheading>
                                            {{ $internship->company }}
                                        </flux:subheading>
                                    </div>
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <flux:icon.map-pin/>
                                            <flux:text>{{ $internship->location }}</flux:text>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <flux:icon.heart/>
                                            <flux:text>{{ $internship->likes_count }} People like this post</flux:text>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </flux:modal>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
