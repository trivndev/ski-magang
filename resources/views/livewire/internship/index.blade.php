@push('aos-head')
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
@endpush
@push('aos-script')
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
@endpush
<div class="flex space-x-12 mx-auto max-w-7xl">
    <div class="space-y-6 min-w-2/5">
        @foreach($this->internships as $internship)
            <x-internship.card :$internship/>
        @endforeach
    </div>
    <div class="flex w-full sticky top-0 h-fit">
        @if($this->selectedInternship())
            <x-internship.job-detail :jobDetail="$this->selectedInternship()"/>
        @endif
    </div>
</div>
