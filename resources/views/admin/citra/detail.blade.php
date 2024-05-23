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
        <h6 class="m-0 font-weight-bold text-primary">Kelola Data Citra Satelit</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pantai</th>
                        <th>Tahun</th>
                        <th>Luasan</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        new DataTable('#usersTable', {
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.citra.detail.ajax", ["id" => $pantai_id]) }}', // Menggunakan route dengan parameter ID
                type: 'GET', // Atur tipe request menjadi GET
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'pantai.nama_pantai', // Menggunakan relasi untuk mengakses nama pantai
                    name: 'pantai.nama_pantai'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'luasan',
                    name: 'luasan'
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
                        if (data.warning) {
                            alert(data.warning);
                        } else {
                            // Handle success, e.g., reload the DataTable
                            // $('#usersTable').DataTable().ajax.reload();
                            location.reload();
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