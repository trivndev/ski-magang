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
<div class="mx-auto max-w-7xl py-8 px-8 md:py-16 min-h-screen flex flex-col space-y-8 space-x-12">
    <x-internship.filter-search/>
    @if($internships->isEmpty())
        <div class="flex-1 w-full flex flex-col justify-center items-center text-center py-16 px-6">

            <div class="absolute inset-0 bg-gradient-to-b from-gray-50 to-white pointer-events-none"></div>
            <h1 class="relative text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                Internships Are Hiding 👀
            </h1>
            <p class="relative text-lg text-gray-600 max-w-2xl mt-4">
                We couldn’t find any internships based on your current search.
                Try adjusting your filters or broadening your search criteria.
                A great opportunity might be just a few clicks away!
            </p>
            <div class="relative flex gap-4 mt-8">
                <button wire:click="resetFilters"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 transition">
                    Reset Filters
                </button>

                <a href="{{ route('internships.index') }}"
                   class="px-6 py-3 border border-gray-300 rounded-xl hover:bg-gray-100 transition">
                    View All Internships
                </a>
            </div>

        </div>
    @else
        <div data-aos="fade-up" data-aos-duration="500" data-aos-once="true" data-aos-anchor-placement="top-bottom"
             class="space-y-8" wire:ignore.self>
            <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-6 md:gap-8">
                @foreach($internships as $internship)
                    <x-internship.card :$internship/>
                @endforeach
            </div>
            {{ $internships->links() }}
        </div>
    @endif

</div>
