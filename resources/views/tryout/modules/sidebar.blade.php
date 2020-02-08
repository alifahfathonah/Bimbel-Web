<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" id="sidebarToggle">
    <div class="sidebar-brand-icon">
        <i class="text-white fas fa-bars"></i>
    </div>
    </a>

    @foreach (config('sidebars.student_sidebar') as $heading)

        @if (count($heading['items']) > 0)
            <!-- Heading -->
            <div class="sidebar-heading mt-3 mb-2">
                {{ $heading['title'] }}
            </div>

            <!-- Divider -->
            <hr class="sidebar-divider mt-0 mb-2">

            @foreach ($heading['items'] as $item)
                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link py-2" href="{{ url($item['url']) }}">
                        <i class="{{ $item['icon'] }}"></i>
                        <span>{{ $item['title'] }}</span>
                    </a>
                </li>
            @endforeach

        @endif

    @endforeach

    <!-- Divider -->
    <hr class="sidebar-divider mt-2">

</ul>
<!-- End of Sidebar -->
