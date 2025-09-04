@push('lottie-head')
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.6.2/dist/dotlottie-wc.js" type="module"></script>
@endpush
@push('lottie-script')
    <script type="module">
        import {DotLottie} from "https://cdn.jsdelivr.net/npm/@lottiefiles/dotlottie-web/+esm";

        new DotLottie({
            autoplay: true,
            loop: true,
            canvas: document.getElementById("canvas"),
            src: "https://lottie.host/4db68bbd-31f6-4cd8-84eb-189de081159a/IGmMCqhzpt.lottie",
        });
    </script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@endpush
<x-layouts.main-app>

</x-layouts.main-app>
