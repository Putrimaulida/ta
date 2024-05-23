@extends('stakeholder.layouts.main')
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
        <h4 class="m-0 font-weight-bold text-primary">Kelola Data Pantai</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pantai</th>
                        <th>Lokasi</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
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
            ajax: '{{ route("stakeholder.data.pantai") }}',
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
    });
</script>
@endsection