@php
    $user = Auth::user();
@endphp
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" id="sidebarToggle">
    <div class="sidebar-brand-icon">
        <i class="text-white fas fa-bars"></i>
    </div>
    </a>

    @foreach (config('sidebars.admin_sidebar') as $heading)

        @if (count($heading['items']) > 0 && $user->role <= intval($heading['role']))
            <!-- Heading -->
            <div class="sidebar-heading mb-1 mt-2">
                {{ $heading['title'] }}
            </div>

            <!-- Divider -->
            <hr class="sidebar-divider mt-0 mb-1">

            @foreach ($heading['items'] as $item)
                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link py-2" href="{{ url($item['url']) }}">
                        <h5 class="align-middle m-0 {{ $item['icon'] }}"></h5>
                        <span class="align-middle">{{ $item['title'] }}</span>
                    </a>
                </li>
            @endforeach

        @endif

    @endforeach

    <!-- Divider -->
    <hr class="sidebar-divider mt-2">

</ul>
<!-- End of Sidebar -->
