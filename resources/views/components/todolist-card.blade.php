@php
    $colorMap = [
            'green' => 'text-green-500',
            'yellow' => 'text-yellow-500',
            'amber' => 'text-amber-500',
            'red' => 'text-red-500',
            'gray' => 'text-gray-500',
        ];
        $colorClass = $colorMap[$todolist->priority->color] ?? 'text-gray-500';
@endphp

<div
    class="p-4 shadow dark:shadow-none bg-white dark:bg-[#303032] border border-gray-100 dark:border-gray-700 rounded-lg transition-all duration-300 space-y-2 sm:min-h-24 md:min-h-36">
    <div class="flex flex-col">
        <flux:heading class="text-xl order-2 line-clamp-1">{{ $todolist->title }}</flux:heading>
        <div class="flex justify-between gap-4 order-1">
            <div class="flex items-center gap-1">
                <flux:icon.exclamation-circle {{ $attributes->merge(['class' => $colorClass]) }}/>
                <flux:text {{ $attributes->merge(['class'=> $colorClass]) }}>{{ $todolist->priority->name }}</flux:text>
            </div>
        </div>
    </div>
    <flux:separator/>
    <flux:text>{{ $todolist->description }}</flux:text>
</div>
