@props(['label' => 'default-label', 'icon' => 'home', 'iconSize' => 'size-12', 'variant' => 'neutral', 'data' => '0'])

@php
    $themes = [
        'success' => [
            'card' => 'bg-gradient-to-br from-emerald-50 to-emerald-100/50 dark:from-emerald-900/30 dark:to-emerald-900/10 border-emerald-200/60 dark:border-emerald-800',
            'icon' => 'text-emerald-600 dark:text-emerald-400',
            'value' => 'text-emerald-700 dark:text-emerald-200',
            'label' => 'text-emerald-700/80 dark:text-emerald-200/70',
        ],
        'danger' => [
            'card' => 'bg-gradient-to-br from-rose-50 to-rose-100/50 dark:from-rose-900/30 dark:to-rose-900/10 border-rose-200/60 dark:border-rose-800',
            'icon' => 'text-rose-600 dark:text-rose-400',
            'value' => 'text-rose-700 dark:text-rose-200',
            'label' => 'text-rose-700/80 dark:text-rose-200/70',
        ],
        'warning' => [
            'card' => 'bg-gradient-to-br from-amber-50 to-amber-100/50 dark:from-amber-900/30 dark:to-amber-900/10 border-amber-200/60 dark:border-amber-800',
            'icon' => 'text-amber-600 dark:text-amber-400',
            'value' => 'text-amber-700 dark:text-amber-200',
            'label' => 'text-amber-700/80 dark:text-amber-200/70',
        ],
        'info' => [
            'card' => 'bg-gradient-to-br from-sky-50 to-sky-100/50 dark:from-sky-900/30 dark:to-sky-900/10 border-sky-200/60 dark:border-sky-800',
            'icon' => 'text-sky-600 dark:text-sky-400',
            'value' => 'text-sky-700 dark:text-sky-200',
            'label' => 'text-sky-700/80 dark:text-sky-200/70',
        ],
        'neutral' => [
            'card' => 'bg-white dark:bg-gray-900 border-gray-100 dark:border-gray-800',
            'icon' => 'text-slate-600 dark:text-slate-300',
            'value' => 'text-slate-800 dark:text-slate-100',
            'label' => 'text-slate-500 dark:text-slate-400',
        ],
    ];

    $theme = $themes[$variant] ?? $themes['neutral'];
    $iconSizeFinal = $attributes->get('icon-size', $iconSize);
@endphp

<div class="group border rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-200 {{ $theme['card'] }}">
    <div class="flex items-start justify-between gap-4">
        <div class="inline-flex items-center justify-center rounded-xl ring-1 ring-black/5 dark:ring-white/5 bg-white/70 dark:bg-white/5 p-2">
            <flux:icon name="{{ $icon }}" class="{{ $iconSizeFinal }} {{ $theme['icon'] }}" variant="solid" />
        </div>
    </div>
    <div class="mt-4">
        <div class="text-sm font-medium {{ $theme['label'] }}">{{ $label }}</div>
        <div class="mt-1 text-3xl font-semibold tracking-tight {{ $theme['value'] }}">{{ $data }}</div>
    </div>
</div>
