@props([
    'title' => null,
])

<section {{ $attributes->merge(['class' => 'card']) }}>
    @if ($title || isset($header))
        <div class="card-header">
            @isset($header)
                {{ $header }}
            @else
                <h2 class="card-title">{{ $title }}</h2>
            @endisset
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endisset
</section>
