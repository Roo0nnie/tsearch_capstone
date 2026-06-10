@props([
    'label' => null,
    'name',
    'type' => 'text',
    'value' => null,
])

<label class="form-group block">
    @if ($label)
        <span class="form-label">{{ $label }}</span>
    @endif
    <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}"
        {{ $attributes->merge(['class' => 'form-control']) }}>
    @error($name)
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</label>
