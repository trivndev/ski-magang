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
    (function () {
        try {
            if (typeof window.initDotLottie !== 'function') {
                throw new Error('initDotLottie is not available');
            }
            window.initDotLottie({
                id: '{{ $id }}',
                src: '{{ asset($src) }}',
                autoplay: {{ $autoplay ? 'true' : 'false' }},
                loop: {{ $loop ? 'true' : 'false' }},
            });
        } catch (e) {
            console.error('Failed to initialize Lottie:', e);
        }
    })();
</script>
