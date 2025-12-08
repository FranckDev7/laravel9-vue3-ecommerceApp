@php
    $colors = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white dark:text-gray-100 focus:ring-blue-500',
        'secondary' => 'bg-gray-800 hover:bg-gray-700 text-white dark:text-gray-200 focus:ring-gray-500',
        'success' => 'bg-green-600 hover:bg-green-700 text-white dark:text-gray-100 focus:ring-green-500',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white dark:text-gray-100 focus:ring-red-500',
    ];

    $sizes = [
        'sm' => 'px-3 py-1 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $colorClasses = $colors[$color] ?? $colors['primary'];
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    $fullWidthClass = $fullWidth ? 'w-full justify-center' : '';
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => "inline-flex items-center $fullWidthClass $sizeClasses $colorClasses border border-transparent rounded-md font-semibold uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150",
        'disabled' => $disabled
    ]) }}
>
    {{ $slot }}
</button>
