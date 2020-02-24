<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#" id="sidebar-brand">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{{ asset('img/icon.png') }}" alt="Manggis" style="max-width: 3.5rem; opacity: .8">
        </div>
        <h3 class="sidebar-brand-text m-0 text-gray-200">
            <strong style="text-transform: none;">Manggis</strong>
        </h3>
    </a>

    @foreach (config('sidebars.student_sidebar') as $heading)

    @if (count($heading['items']) > 0)

    @isset($heading['title'])
    <!-- Heading -->
    <div class="sidebar-heading mb-1 mt-2">
        {{ $heading['title'] }}
    </div>
    <!-- Divider -->
    <hr class="sidebar-divider mt-0 mb-1">
    @else
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    @endisset

    @foreach ($heading['items'] as $nav_item)
    @isset ($nav_item['items'])

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ is_active($nav_item['uri'] ?? '') }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse{{ $nav_item['uri'] }}"
            aria-expanded="true" aria-controls="collapse{{ $nav_item['uri'] }}">
            <i class="{{ $nav_item['icon'] ?? '' }}"></i>
            <span>{{ $nav_item['title'] ?? '' }}</span>
        </a>
        <div id="collapse{{ $nav_item['uri'] }}" class="collapse" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @foreach ($nav_item['items'] as $collapse_header)
                @empty($collapse_header['items'])
                @continue
                @endempty

                <h6 class="collapse-header">{{ $collapse_header['title'] ?? ''}}</h6>

                @foreach ($collapse_header['items'] as $item)
                <a class="collapse-item" href="{{ isset($item['route']) ? route($item['route']) : '#' }}">
                    {{ $item['title'] }}
                </a>
                @endforeach

                @endforeach
            </div>
        </div>
    </li>

    @else

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ is_active($nav_item['uri'] ?? '') }}">
        <a class="nav-link" href="{{ isset($nav_item['route']) ? route($nav_item['route']) : '#' }}"
            {{ $nav_item['title'] == 'Logout' ? 'data-toggle=modal data-target=#logoutModal':'' }}>
            <i class="{{ $nav_item['icon'] ?? '' }}"></i>
            <span>{{ $nav_item['title'] ?? '' }}</span>
        </a>
    </li>

    @endisset
    @endforeach

    @endif

    @endforeach

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

@push('js')
<style>
    .nav-item.active {
        border-left: 0.3rem solid rgba(255, 255, 255, .7);
    }

    .nav-item.active .nav-link {
        margin-left: -0.3rem;
    }
</style>
@endpush
