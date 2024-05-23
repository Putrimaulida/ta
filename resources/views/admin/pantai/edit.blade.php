@extends('admin.layouts.main')
@section('container')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Data Pantai</div>

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

                    <form method="POST" action="{{ url('/dashboard_admin/pantai/update/'.$pantai->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Nama Pantai -->
                        <div class="form-group">
                            <label for="nama_pantai">Nama Pantai:</label>
                            <input type="text" name="nama_pantai" id="nama_pantai" class="form-control" value="{{ $pantai->nama_pantai }}" required>
                        </div>
                        <!-- Lokasi -->
                        <div class="form-group">
                            <label for="lokasi_pantai">Lokasi:</label>
                            <input type="text" name="lokasi_pantai" id="lokasi_pantai" class="form-control" value="{{ $pantai->lokasi_pantai }}" required>
                        </div>
                        <!-- Longitude -->
                        <div class="form-group">
                            <label for="longitude">Longitude:</label>
                            <input type="text" name="longitude" id="longitude" class="form-control" value="{{ $pantai->longitude }}" required>
                        </div>
                        <!-- Latitude -->
                        <div class="form-group">
                            <label for="latitude">Latitude:</label>
                            <input type="latitude" name="latitude" id="latitude" class="form-control" value="{{ $pantai->latitude }}" required>
                        </div>
                        <div id="jenisMangroveFields">
                            @foreach($pantai->jenisMangroves as $jenis)
                                <div class="form-group">
                                    <label for="jenis_mangrove">Jenis Mangrove:</label>
                                    <div class="input-group">
                                        <select name="jenis_mangrove_id[]" class="form-control" required>
                                            <option value="">Pilih Jenis Mangrove</option>
                                            @foreach($jenisMangrove as $id => $nama_ilmiah)
                                                <option value="{{ $id }}" {{ $id == $jenis->id ? 'selected' : '' }}>{{ $nama_ilmiah }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                        <button type="button" class="btn btn-danger removeJenisMangrove">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success" id="addJenisMangrove"><i class="fas fa-plus"></i>Tambah Jenis Mangrove</button>
                        </div>
                        <div class="form-group">
                            <label for="image">Gambar:</label>
                            <input type="file" name="image" id="image" class="form-control">
                            <small id="image" class="form-text" text-muted>Maksimal file ukuran: 2048 Kb (Mb)</small>
                        </div>
                        <div class="form-group">
                            <label for="video">Video:</label>
                            <input type="file" name="video" id="video" class="form-control">
                            <small id="video" class="form-text" text-muted>Maksimal file ukuran: 2048 Kb (Mb)</small>
                        </div>
                        <div id="map" style="height: 500px;"></div>
                        <!-- Submit Button -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{ url('/dashboard_admin/pantai') }}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary">Update Pantai</button>
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
        $("#addJenisMangrove").click(function(){
            var html = '<div class="form-group">' +
                            '<label for="jenis_mangrove">Jenis Mangrove:</label>' +
                            '<div class="input-group">' +
                                '<select name="jenis_mangrove_id[]" class="form-control" required>' +
                                    '<option value="">Pilih Jenis Mangrove</option>' +
                                    '@foreach($jenisMangrove as $id => $nama_ilmiah)' +
                                        '<option value="{{ $id }}">{{ $nama_ilmiah }}</option>' +
                                    '@endforeach' +
                                '</select>' +
                                '<div class="input-group-append">' +
                                    '<button type="button" class="btn btn-danger removeJenisMangrove">' +
                                        '<i class="fa fa-trash"></i>' +
                                    '</button>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            $("#jenisMangroveFields").append(html);
        });
        // Fungsi untuk menghapus input jenis mangrove
        $(document).on('click', '.removeJenisMangrove', function(){
            $(this).closest('.form-group').remove();
        });
    });
</script>
<script>
        var defaultLatitude = -8.37501488161054; // Latitude default
        var defaultLongitude = 112.37609297163199; // Longitude default
        var map = L.map('map').setView([defaultLatitude, defaultLongitude], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        var marker = L.marker([defaultLatitude, defaultLongitude], {
            draggable: true
        }).addTo(map);

        // Tangani perubahan posisi marker
        marker.on('dragend', function(event) {
            var marker = event.target;
            var position = marker.getLatLng();
            // Update nilai latitude dan longitude pada input
            document.getElementById('latitude').value = position.lat;
            document.getElementById('longitude').value = position.lng;
        });

        // Fungsi untuk menyesuaikan posisi marker berdasarkan nilai latitude dan longitude dari inputan
        function setMarkerPosition() {
            var latitude = parseFloat(document.getElementById('latitude').value);
            var longitude = parseFloat(document.getElementById('longitude').value);
            if (!isNaN(latitude) && !isNaN(longitude)) {
                marker.setLatLng([latitude, longitude]);
                map.panTo([latitude, longitude]);
            }
        }

        // Panggil fungsi setMarkerPosition saat halaman dimuat
        setMarkerPosition();
    </script>
@endsection