<div class="form-group row">
    <label for="{{ $name }}" class="col-sm-3 col-form-label text-right">
        {{ $label }}
    </label>
    <div class="col-sm-9">
    @empty($input)
        <input type="{{ $type ?? 'text' }}"
            class="form-control @error($name) is-invalid @enderror {{ $class ?? '' }}"
            id="{{ $name }}"
            name="{{ $name }}"
            placeholder="{{ $label }}"
            value="{{ old($name) ?? $value ?? '' }}"
            {{ $prop ?? ''}}
            >
    @else
        {{ $input }}
    @endempty

        @error($name)
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

    </div>
</div>
