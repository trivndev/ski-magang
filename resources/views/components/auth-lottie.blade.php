<div class="w-full hidden lg:block aspect-square" wire:ignore>
    <div
        class="flex-1 h-full aspect-square w-full rounded-xl bg-gradient-to-br from-gray-500 to-gray-600 dark:from-gray-800 dark:to-gray-900 p-6 hidden lg:flex">
        <div class="text-white flex flex-col justify-center items-center w-full">
            <div>
                <canvas id="greetings" class="min-size-96 w-full"></canvas>
                <script type="module">
                    const dotLottie = new DotLottie({
                        autoplay: true,
                        loop: true,
                        canvas: document.querySelector('#greetings'),
                        src: "{{ asset('lotties/Welcome.lottie') }}"
                    });
                </script>
            </div>
        </div>
    </div>
</div>
