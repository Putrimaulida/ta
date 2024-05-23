@extends('admin.layouts.main')
@section('container')
@if (session('info'))
<div class="alert alert-info">
    {{ session('info') }}
    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <script>
        setTimeout(function() {
            document.getElementById('logout-form').submit();
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>
</div>
@endif
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
@if (session('warning'))
<div class="alert alert-warning">
    {{ session('warning') }}
</div>
@endif
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-primary">Kelola Data Pantai</h5>
    </div>
    <div class="card-body">
        <a href="{{ url('/dashboard_admin/pantai/create') }}" class="btn btn-success float-right mb-3">
            <i class="fas fa-plus"></i> Tambah Data Pantai
        </a>
        <div class="table-responsive">
            <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Nama Pantai</th>
                    <th style="width: 25%;">Lokasi</th>
                    <th style="width: 15%;">Longitude</th>
                    <th style="width: 15%;">Latitude</th>
                    <th style="width: 13%;">Action</th>
                </tr>
            </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- menampilkan data dari model -->
<script>
    $(document).ready(function() {
        new DataTable('#usersTable', {
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.data.pantai") }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_pantai',
                    name: 'nama_pantai'
                },
                {
                    data: 'lokasi_pantai',
                    name: 'lokasi_pantai'
                },
                {
                    data: 'longitude',
                    name: 'longitude'
                },
                {
                    data: 'latitude',
                    name: 'latitude'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });

        $('#usersTable').on('click', 'button.delete-users', function(e) {
            e.preventDefault();
            var deleteUrl = $(this).data('url');

            if (confirm('Are you sure?')) {
                fetch(deleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.success);
                            location.reload();
                        } else {
                            // Handle success, e.g., reload the DataTable
                            // $('#usersTable').DataTable().ajax.reload();
                        }
                    })

                    .catch(error => {
                        // Handle error
                        console.error(error);
                    });
            }
        });
    });
</script>
@endsection