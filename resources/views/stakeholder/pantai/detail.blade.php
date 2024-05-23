@extends('stakeholder.layouts.main')
@section('container')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="font-weight-bold" style="font-size: 1.2rem;">Detail {{ $pantai->nama_pantai }}</span>
                <a href="{{ url()->previous() }}">
                    <i class="fas fa-times"></i>
                </a>
            </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                        <p><strong>Nama Pantai:</strong> {{ $pantai->nama_pantai }} </p>
                            <p><strong>Lokasi Pantai:</strong> {{ $pantai->lokasi_pantai }}</p>
                            <p><strong>Longitude:</strong> {{ $pantai->longitude }}</p>
                            <p><strong>Latitude:</strong> {{ $pantai->latitude }}</p>
                            <p><strong>Jenis-jenis Mangrove:</strong>
                            @foreach ($pantai->jenisMangroves as $jenisMangrove)
                                {{ $jenisMangrove->nama_ilmiah }}{{ !$loop->last ? ',' : '' }}
                            @endforeach
                            </p>
                            <p><strong>Data Citra Satelit:</strong> <a href="{{ url('dashboard_admin/citra') . '/' . $pantai->id }}">klik disini</a></p>
                            <p><strong>Data Lapang:</strong> <a href="{{ url('dashboard_admin/lapang') }}">klik disini</a></p>
                            @if($pantai->status==1)
                            <p><strong>Komen:</strong> {{ $pantai->komen }}</p>
                            @endif
                            <p><strong>Gambar:</strong></p>
                            <img src="{{ asset('storage/' . $pantai->image) }}" alt="Gambar Pantai" width="300">
                            <p><strong></strong></p>
                            <p><strong>Video:</strong></p>
                            <video controls width="300" height="auto">
                                <source src="{{ asset('storage/' . $pantai->video) }}" type="video/mp4">
                                Browser Anda tidak mendukung tag video.
                            </video>
                            <div id="map-datang" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    // Pastikan variabel $pantai->latitude dan $pantai->longitude sudah terdefinisi dan mendapatkan nilai yang sesuai
    var latitude = {{ $pantai->latitude }};
    var longitude = {{ $pantai->longitude }};
    var datangMap = L.map('map-datang').setView([latitude, longitude], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(datangMap);
    L.marker([latitude, longitude]).addTo(datangMap)
    .bindPopup("{{ $pantai->nama_pantai }}")
        .openPopup();
</script>
@endsection