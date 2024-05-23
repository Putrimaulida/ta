@extends('admin.layouts.main')
@section('container')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Data Jenis Mangrove</div>

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

                    <form method="POST" action="{{ url('/dashboard_admin/jenis_mangrove/update/' .$jenisMangrove->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Keluarga Mangrove -->
                        <div class="form-group">
                            <label for="nama_keluarga_select">Pilih Keluarga:</label>
                            <select name="nama_keluarga_select" id="nama_keluarga_select" class="form-control">
                                <option value="">-- Pilih Keluarga --</option>
                                @foreach($jenisMangroves as $jenisMangroveOption)
                                <option value="{{ $jenisMangroveOption->nama_keluarga }}" {{ $jenisMangroveOption->nama_keluarga == $jenisMangrove->nama_keluarga ? 'selected' : '' }}>
                                    {{ $jenisMangroveOption->nama_keluarga }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama Ilmiah -->
                        <div class="form-group mt-2">
                            <label for="nama_ilmiah">Nama Ilmiah:</label>
                            <input type="text" name="nama_ilmiah" id="nama_ilmiah" class="form-control" value="{{ old('nama_ilmiah', $jenisMangrove->nama_ilmiah) }}" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{ url('/dashboard_admin/jenis_mangrove') }}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary">Update Jenis Mangrove</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
