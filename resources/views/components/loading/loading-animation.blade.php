@props(['loadingTarget' => null])

<div
    class="fixed inset-0 z-[9999] bg-white/50 backdrop-blur-xs"
    @if($loadingTarget)
        wire:loading wire:target="{{ $loadingTarget }}"
    @else
        wire:loading
    @endif
>
    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-row gap-3">
        <div class="w-4 h-4 rounded-full animate-bounce animate-color-shift"></div>
        <div class="w-4 h-4 rounded-full animate-bounce animate-color-shift [animation-delay:-.3s]"></div>
        <div class="w-4 h-4 rounded-full animate-bounce animate-color-shift [animation-delay:-.5s]"></div>
    </div>
</div>
