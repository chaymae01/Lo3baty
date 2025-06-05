@props([
    'active' => false,
    'icon' => '',
    'label' => '',
    'href' => '#',
])

@php
$classes = ($active)
    ? 'inline-flex items-center px-4 py-2 rounded bg-gray-100 text-indigo-700 font-medium'
    : 'inline-flex items-center px-4 py-2 rounded hover:bg-gray-100 text-gray-600 hover:text-indigo-600 transition';

@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if ($icon)
        <i class="fas fa-{{ $icon }} w-5 text-indigo-500"></i>
    @endif
    <span class="ml-2">{{ $label ?: $slot }}</span>
</a>
