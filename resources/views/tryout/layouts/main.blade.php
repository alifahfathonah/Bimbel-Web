@include('tryout.modules.sidebar')

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        @include('tryout.modules.header')
        <div class="container-fluid" id="app">
            @yield('content')
        </div>
    </div>
    {{-- @include('tryout.modules.footer') --}}
</div>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Are you sure to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{ route('tryout.logout') }}">Logout</a>
            </div>
        </div>
    </div>
</div>
