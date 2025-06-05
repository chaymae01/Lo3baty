@props(['icon' => '', 'label' => '', 'text' => '', 'color' => 'indigo'])

<div class="bg-white rounded-xl shadow-md border-l-4 p-6 border-{{ $color }}-500">
    <h2 class="text-xl font-semibold flex items-center gap-2">
        <i class="fas fa-{{ $icon }}"></i> {{ $label }}
    </h2>
    <p class="text-gray-600 mt-2">{{ $text }}</p>
</div>
