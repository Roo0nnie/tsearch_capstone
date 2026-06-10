@props([
    'id' => 'tabs-' . uniqid(),
])

<div {{ $attributes->merge(['class' => 'space-y-4']) }} data-ui-tabs id="{{ $id }}">
    {{ $slot }}
</div>
