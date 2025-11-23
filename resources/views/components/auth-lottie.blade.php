@props([
    'id' => 'greetings',
    'class' => '',
    'src' => 'lotties/Welcome.lottie',
    'autoplay' => true,
    'loop' => true,
    'controls' => true,
    'muted' => true,
])
@php
    $finalClass = 'min-size-96 w-full';
@endphp
<div class="w-full hidden lg:block aspect-square" wire:ignore>
    <div
        class="flex-1 h-full aspect-square w-full rounded-xl bg-gradient-to-br from-gray-500 to-gray-600 dark:from-gray-800 dark:to-gray-900 p-6 hidden lg:flex">
        <div class="text-white flex flex-col justify-center items-center w-full">
            <div>
                <canvas id="{{ $id }}" {{ $attributes->merge(['class' => $finalClass]) }}></canvas>
                @vite('resources/js/lottie.js')
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
            </div>
        </div>
    </div>
</div>
