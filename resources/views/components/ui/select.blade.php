@props([
    'label' => null,
    'name',
    'options' => [],
    'value' => null,
    'placeholder' => null,
])

<label class="form-group block">
    @if ($label)
        <span class="form-label">{{ $label }}</span>
    @endif
    <select name="{{ $name }}" {{ $attributes->merge(['class' => 'form-select']) }}>
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected(old($name, $value) == $optionValue)>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
    @error($name)
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</label>
