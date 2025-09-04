<div data-aos="fade-up" data-aos-duration="1000" data-aos-once="true" data-aos-anchor-placement="top-bottom">
    <a href="{{ route('internship.index', ['jobId' => $internship->id])}}"
       class="p-6 block rounded-lg shadow outline outline-gray-50 dark:outline-gray-500 hover:outline-blue-500 transition-colors duration-300 cursor-pointer space-y-2 dark:shadow-none overflow-hidden"
       wire:navigate>
        <div><h1 class="text-lg font-medium">{{ $internship->job_title }}</h1></div>
        <div><h2>{{ $internship->company }}</h2></div>
        <div><p class="text-sm">{{ $internship->location }}</p></div>
        <div class="flex justify-between items-center">
            <div>Posted {{ $internship->created_at->diffForHumans() }}</div>
            <div class="flex">
                <div>
                    <flux:tooltip content="Like this job">
                        <flux:button icon:variant="outline" variant="ghost" icon="heart"/>
                    </flux:tooltip>
                </div>
                <div>
                    <flux:tooltip content="Bookmark this job">
                        <flux:button icon:variant="outline" variant="ghost" icon="bookmark"/>
                    </flux:tooltip>
                </div>
            </div>
        </div>
    </a>
</div>
