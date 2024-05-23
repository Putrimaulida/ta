@extends('admin.layouts.main')
@section('container')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tambah Data Pantai</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ url('/dashboard_admin/jenis_mangrove/create/store') }}" enctype="multipart/form-data">
                            @csrf
                            @if($jenisMangroves->isNotEmpty())
                                <!-- Nama Keluarga -->
                                <div class="form-group">
                                    <label for="nama_keluarga_select">Pilih Keluarga:</label>
                                    <select name="nama_keluarga_select" id="nama_keluarga_select" class="form-control">
                                        <option value="">-- Pilih Keluarga --</option>
                                        @foreach($jenisMangroves as $jenisMangrove)
                                            <option value="{{ $jenisMangrove->nama_keluarga }}">{{ $jenisMangrove->nama_keluarga }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="nama_keluarga_manual">Atau Masukkan Keluarga Baru:</label>
                                    <input type="text" name="nama_keluarga_manual" id="nama_keluarga_manual" class="form-control">
                                </div>
                            @else
                                <div class="form-group mt-2">
                                    <label for="nama_keluarga_manual">Masukkan Keluarga:</label>
                                    <input type="text" name="nama_keluarga_manual" id="nama_keluarga_manual" class="form-control" required>
                                </div>
                            @endif

                            <!-- Nama Ilmiah -->
                            <div class="form-group mt-2">
                                <label for="nama_ilmiah">Nama Ilmiah:</label>
                                <input type="text" name="nama_ilmiah" id="nama_ilmiah" class="form-control" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <a href="{{ url('/dashboard_admin/jenis_mangrove') }}" class="btn btn-secondary">Back</a>
                                    <button type="submit" class="btn btn-primary">Tambah Jenis Mangrove</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#nama_keluarga_select').on('change', function() {
                if ($(this).val() !== "") {
                    $('#nama_keluarga_manual').val('').prop('disabled', true);
                } else {
                    $('#nama_keluarga_manual').prop('disabled', false);
                }
            });

            $('#nama_keluarga_manual').on('input', function() {
                if ($(this).val() !== "") {
                    $('#nama_keluarga_select').val('').prop('disabled', true);
                } else {
                    $('#nama_keluarga_select').prop('disabled', false);
                }
            });
        });
    </script>
@endsection
