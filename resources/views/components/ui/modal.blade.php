@props([
    'id',
    'title' => null,
    'size' => '2xl',
])

@php
    $sizeClass = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-4xl',
        'xl' => 'max-w-5xl',
        '2xl' => 'max-w-2xl',
    ][$size] ?? 'max-w-2xl';
@endphp

<div id="{{ $id }}" {{ $attributes->merge(['class' => 'modal']) }} data-ui-modal aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered {{ $sizeClass }}">
        <div class="modal-content">
            @if ($title || isset($header))
                <div class="modal-header">
                    @isset($header)
                        {{ $header }}
                    @else
                        <h2 class="modal-title">{{ $title }}</h2>
                    @endisset
                    <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Close"></button>
                </div>
            @endif

            <div class="modal-body">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
