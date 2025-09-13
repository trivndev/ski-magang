@push('aos-head')
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
@endpush
@push('aos-script')
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
@endpush
<div class="flex space-x-12 mx-auto max-w-7xl py-8 px-4 md:py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-6">
        @foreach($this->internships as $internship)
            <x-internship.card :$internship/>
        @endforeach
    </div>
</div>
