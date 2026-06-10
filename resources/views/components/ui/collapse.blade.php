@props([
    'id',
    'label' => null,
    'open' => false,
])

<div {{ $attributes->merge(['class' => 'space-y-2']) }}>
    @isset($trigger)
        <div data-ui-toggle="collapse" data-ui-target="#{{ $id }}" aria-expanded="{{ $open ? 'true' : 'false' }}">
            {{ $trigger }}
        </div>
    @else
        <button type="button" class="btn btn-link w-100 justify-content-between" data-ui-toggle="collapse"
            data-ui-target="#{{ $id }}" aria-expanded="{{ $open ? 'true' : 'false' }}">
            {{ $label ?? 'Toggle' }}
            <span class="caret"></span>
        </button>
    @endisset

    <div id="{{ $id }}" class="collapse {{ $open ? 'show' : '' }}">
        {{ $slot }}
    </div>
</div>
