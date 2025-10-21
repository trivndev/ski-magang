import { DotLottie } from '@lottiefiles/dotlottie-web';
export function initDotLottie({ id, src, autoplay = true, loop = true }) {
    const canvas = document.getElementById(id);
    if (!canvas) return;

    new DotLottie({
        autoplay,
        loop,
        canvas,
        src,
    });
}

if (typeof window !== 'undefined') {
    window.initDotLottie = initDotLottie;
}
