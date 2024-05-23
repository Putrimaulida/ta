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
            <h5 class="m-0 font-weight-bold text-primary">Hasil Analisis dan Garis Trend Pengelolaan Vegetasi Mangrove</h5>
        </div>
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

            <div class="form-group col-md-3">
                <label for="pantai_id">Pilih Nama Pantai:</label>
                <select name="pantai_id" id="pantai_id" class="form-control" required>
                    <option value="all">All</option>
                    @foreach ($dataRekomendasiPantai as $pantai)
                        <option value="{{ $pantai->id }}">
                            {{ $pantai->nama_pantai }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-3">
                <label for="tahun">Tentukan Tahun:</label>
                <select name="tahun" id="tahun" class="form-control">
                    <option value="">All</option>
                </select>
            </div>
            <!-- Submit Button -->
            <div class="row mt-3">
                <div class="col-md-12">
                    {{-- <a href="#" class="btn btn-secondary">Back</a> --}}
                    <button type="submit" onclick="countRekomendasi()" class="btn btn-primary">Kirim</button>
                </div>
            </div>

            <!-- Grafik -->
            <h5 class="text-center"><b>Grafik Data Citra Satelit</b></h5>
            <canvas id="myChart" width="400" height="200"></canvas>
            <div class="row mt-5" id="conclusion" hidden>
                <div class="col">
                    <h1>Kesimpulan :</h1>
                    <p id="text-conclusion"></p>
                </div>
            </div>
            <!-- Script Chart.js -->
            <!-- End Script Chart.js -->

        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
        function countRekomendasi() {
            var pantai_id = $('#pantai_id').val();

            if (pantai_id == 'all') {
                $.ajax({
                    url: "{{ route('countAllRecommendedStakeholder') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "pantai_id": pantai_id,
                    },
                    success: function(response) {
                        if (response.success == true) {
                            var pantaiData = response.data;
                            myChart.data.labels = [];
                            myChart.data.datasets = [];

                            pantaiData.forEach(function(dataPantai) {
                                var tahun_pantai = Object.keys(dataPantai.luasan_tiap_tahun);
                                var pantai = dataPantai.pantai;
                                var luasan_tiap_tahun = Object.values(dataPantai.luasan_tiap_tahun);
                                var result = dataPantai.result;
                                var borderColor = dataPantai.borderColor;

                                var tahun_prediksi = Object.keys(result)[0];
                                if (!tahun_pantai.includes(tahun_prediksi)) {
                                    tahun_pantai.push(tahun_prediksi);
                                    luasan_tiap_tahun.push(result[tahun_prediksi]);
                                }

                                myChart.data.datasets.push({
                                    label: pantai,
                                    data: luasan_tiap_tahun,
                                    borderColor: borderColor,
                                    borderWidth: 1,
                                    fill: false
                                });

                                tahun_pantai.forEach(function(tahun) {
                                    if (!myChart.data.labels.includes(tahun)) {
                                        myChart.data.labels.push(tahun);
                                    }
                                });
                            });

                            myChart.update();
                            var conclusionHTML = pantaiData[0].conclusion;
                            $('#text-conclusion').html(conclusionHTML);
                            $('#conclusion').removeAttr('hidden');
                        } else {
                            alert('Gagal menghitung rekomendasi.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            } else {
                $.ajax({
                    url: "{{ route('countRecommendedStakeholder') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "pantai_id": pantai_id,
                    },
                    success: function(response) {
                        if (response.success == true) {
                            var data = response.data;
                            var tahun = Object.keys(data.luasan_tiap_tahun);
                            myChart.data.labels = [];
                            myChart.data.datasets = [];
                            var pantai = data.pantai;
                            var luasan_tiap_tahun = Object.values(data.luasan_tiap_tahun);
                            var result = data.result;
                            var borderColor = data.borderColor;

                            var tahun_prediksi = Object.keys(result)[0];
                            if (!tahun.includes(tahun_prediksi)) {
                                tahun.push(tahun_prediksi);
                                luasan_tiap_tahun.push(result[tahun_prediksi]);
                            }

                            myChart.data.labels = tahun;
                            myChart.data.datasets.push({
                                label: pantai,
                                data: luasan_tiap_tahun,
                                borderColor: borderColor,
                                borderWidth: 1,
                                fill: false
                            });
                            myChart.update();

                            var conclusionHTML = response.data.conclusion;
                            $('#text-conclusion').html(conclusionHTML);
                            $('#conclusion').removeAttr('hidden');
                        } else {
                            alert('Gagal menghitung rekomendasi.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            }
        }

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                    borderColor: '',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
