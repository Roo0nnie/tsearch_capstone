@props([
    'align' => 'right',
    'label' => null,
])

@php
    $menuClass = $align === 'left' ? 'dropdown-menu dropdown-menu-start' : 'dropdown-menu dropdown-menu-end';
@endphp

<div {{ $attributes->merge(['class' => 'dropdown inline-block']) }} data-ui-dropdown>
    @isset($trigger)
        <div data-ui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ $trigger }}
        </div>
    @else
        <button type="button" class="btn btn-light dropdown-toggle" data-ui-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            {{ $label ?? 'Open menu' }}
        </button>
    @endisset

    <div class="{{ $menuClass }}" data-ui-menu>
        {{ $slot }}
    </div>
</div>
