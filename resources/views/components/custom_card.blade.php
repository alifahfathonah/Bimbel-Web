<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-{{ $type ?? '' }} shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                @if (isset($value) && isset($title))
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-{{ $type ?? '' }} text-uppercase mb-1">{{ $title ?? '' }}</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $value ?? '' }}</div>
                </div>
                @else
                    {{ $slot }}
                @endif

                @isset($icon)
                <div class="col-auto">
                    <i class="{{ $icon ?? '' }} fa-2x text-gray-300"></i>
                </div>
                @endisset
            </div>
        </div>
    </div>
</div>
