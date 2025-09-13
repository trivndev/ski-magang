@props([
    'id' => '',
    'class' => '',
    'src' => '',
    'autoplay' => true,
    'loop' => true,
    'controls' => true,
    'muted' => true,
])
@php
    $finalClass = trim($class . ' w-full max-w-xs md:max-w-md aspect-square h-auto mx-auto');
@endphp
<canvas id="{{ $id }}" {{ $attributes->merge(['class' => $finalClass]) }}></canvas>
<script type="module">
    const dotLottie = new DotLottie({
        autoplay: {{ $autoplay ? 'true' : 'false' }},
        loop: {{ $loop ? 'true' : 'false' }},
        canvas: document.getElementById("{{ $id }}"),
        src: "{{ asset($src) }}",
    });
</script>
