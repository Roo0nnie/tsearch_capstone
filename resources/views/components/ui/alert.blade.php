@props([
    'variant' => 'info',
])

<div {{ $attributes->merge(['class' => "alert alert-{$variant}"]) }} role="alert">
    {{ $slot }}
</div>
