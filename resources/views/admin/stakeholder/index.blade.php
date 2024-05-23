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
            <h5 class="m-0 font-weight-bold text-primary">Kelola Data Pengguna (Stakeholder)</h5>
        </div>
        <div class="card-body">
            <a href="{{ url('/dashboard_admin/stakeholder_management/create') }}" class="btn btn-success float-right mb-3">
                <i class="fas fa-plus"></i> Create Users
            </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengguna</th>
                            <th>Email Pengguna</th>
                            <th>Action</th>
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
        ajax: '{{ route("admin.data.stakeholder") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
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
                } else {
                    // Handle success, e.g., reload the DataTable
                    //$('#example').DataTable().ajax.reload();
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