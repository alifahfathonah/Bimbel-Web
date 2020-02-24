<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">

            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <div class="d-none d-lg-inline text-right">
                    <small class="text-gray-600 d-block">{{ get_user('student')->name }}</small>
                    <small class="d-block">{{ get_user('student')->username }}</small>
                </div>
                <div class="topbar-divider d-none d-sm-block"></div>
                <img class="img-profile rounded-circle" src="{{ asset('img/user.png') }}">
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <div class="d-flex flex-column px-3 py-2">
                    <p class="m-0">{{ get_user('student')->name }}</p>
                    <small>{{ get_user('student')->username }}</small>
                </div>
                <hr class="my-2">
                <a class="dropdown-item" href="{{ route('tryout.profile') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
