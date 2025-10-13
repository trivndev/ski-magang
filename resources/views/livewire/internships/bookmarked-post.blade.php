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
    <div class="space-y-4 w-full">
        <flux:heading class="text-xl">
            Bookmarked Posts
        </flux:heading>
        <x-internship.filter-search/>
    </div>
    <div data-aos="fade-up" data-aos-duration="500" data-aos-once="true" data-aos-anchor-placement="top-bottom"
         class="space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-6 md:gap-8">
            @foreach($internships as $internship)
                <x-internship.card :$internship/>
            @endforeach
        </div>
        {{ $internships->links() }}
    </div>
</div>
