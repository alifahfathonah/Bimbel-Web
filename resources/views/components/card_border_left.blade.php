<div class="{{ $class ?? 'col-12 col-md-6 mb-4' }}">
    <div class="card border-left-{{ $type ?? 'primary' }} shadow h-100 py-2">
        <div class="card-body">
            <div class="col no-gutters">
                @isset($header)
                {{ $header }}
                <hr>
                @endisset
                {{ $slot }}
                @isset($footer)
                    <hr>
                    {{ $footer }}
                @endisset
            </div>
        </div>
    </div>
</div>
