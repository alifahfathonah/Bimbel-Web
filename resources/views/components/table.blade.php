<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                @foreach ($colums as $column)
                    <th>{{ $column }}</th>
                @endforeach
            </tr>
        </thead>
        <tfoot>
            <tr>
                @foreach ($colums as $column)
                    <th>{{ $column }}</th>
                @endforeach
            </tr>
        </tfoot>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('js')
<!-- Page level plugins -->
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $(document).ready(function () {
            $('#dataTable').DataTable();
        } );
</script>
@endpush
