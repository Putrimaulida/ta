@extends('admin.layouts.main')
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
                            <div class="col-md-10" style="text-align: justify;">
                                <p><strong>Informasi Pantai:</strong></p>
                                <p>
                                    Pantai {{ $pantai->nama_pantai }} terletak di {{ $pantai->lokasi_pantai }}. 
                                    Koordinat pantai ini adalah {{ $pantai->latitude }}° LS dan {{ $pantai->longitude }}° BT. 
                                    Pantai ini memiliki beberapa jenis mangrove seperti 
                                    @foreach ($pantai->jenisMangroves as $jenisMangrove)
                                        {{ $jenisMangrove->nama_ilmiah }}{{ !$loop->last ? ',' : '.' }}
                                    @endforeach
                                    Untuk melihat data citra satelit, silakan <a href="{{ url('dashboard_admin/citra') . '/' . $pantai->id }}">klik di sini</a>. 
                                    Sedangkan untuk data lapang, <a href="{{ url('dashboard_admin/lapang') }}">klik di sini</a>.
                                </p>
                                @if ($pantai->status == 1)
                                    <p>
                                        Laporan mengenai pantai ini: {{ $pantai->komen }}.
                                    </p>
                                @endif
                                <p>
                                    Untuk melihat video pantai, <a href="{{ $pantai->video }}" target="_blank">klik di sini</a>.
                                </p>
                                <p>
                                    Berikut adalah luasan mangrove jika dilihat dari peta perubahan:
                                </p>
                                @if ($pantai->pantaiImages)
                                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width: 500px;">
                                        <ol class="carousel-indicators">
                                            @foreach ($pantai->pantaiImages as $listfoto)
                                                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                                            @endforeach
                                        </ol>
                                        <div class="carousel-inner">
                                            @foreach ($pantai->pantaiImages as $listfoto)
                                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                    <img class="d-block w-100" src="{{ asset('storage/' . $listfoto->path) }}" alt="Gambar Pantai" style="width: 500px;">
                                                </div>
                                            @endforeach
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                @endif
                                <p>
                                    Berikut adalah lokasi pantai:
                                </p>
                                <div id="map-datang" style="height: 300px;"></div>
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