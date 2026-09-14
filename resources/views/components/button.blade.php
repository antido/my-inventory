@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
    'fullWidth' => false,
])

@php
    $classes = 'button';
    $classes .= $variant === 'secondary' ? ' secondary' : '';
    $classes .= $fullWidth ? ' full-width' : '';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
