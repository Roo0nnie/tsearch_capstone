@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
])

@php
    $variantClass = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'danger' => 'btn-danger',
        'success' => 'btn-success',
        'warning' => 'btn-warning',
        'light' => 'btn-light',
        'dark' => 'btn-dark',
        'outline' => 'btn-outline-primary',
        'link' => 'btn-link',
    ][$variant] ?? 'btn-primary';

    $sizeClass = [
        'sm' => 'btn-sm',
        'md' => '',
        'lg' => 'btn-lg',
    ][$size] ?? '';

    $class = trim("btn {$variantClass} {$sizeClass}");
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </button>
@endif
