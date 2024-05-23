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
                <option value="all">All</option>
                @foreach ($allYears as $year)
                <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
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
    </div>
</div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
    var myChart;
    function countRekomendasi() {
    var pantai_id = $('#pantai_id').val();
    var tahun = $('#tahun').val();

    $.ajax({
        url: "{{ route('countRecommended') }}",
        type: "POST",
        data: {
            "_token": "{{ csrf_token() }}",
            "pantai_id": pantai_id,
            "tahun": tahun
        },
        success: function(response) {
            if (response.success == true) {
                var pantaiData = response.data;
                var labels = [];
                var datasets = [];

                if (pantai_id == 'all' && tahun == 'all') {
                    // Menangani kasus di mana semua pantai dan semua tahun dipilih
                    var uniqueYears = new Set();

                    // Mengumpulkan semua tahun unik
                    pantaiData.forEach(function(dataPantai) {
                        var luasan = dataPantai.luasan_tiap_tahun;
                        Object.keys(luasan).forEach(function(year) {
                            uniqueYears.add(year);
                        });
                    });

                    labels = Array.from(uniqueYears).sort(); // Mengubah Set menjadi Array dan mengurutkan

                    // Mempersiapkan datasets
                    pantaiData.forEach(function(dataPantai) {
                        var pantai = dataPantai.pantai;
                        var luasan = dataPantai.luasan_tiap_tahun;
                        var borderColor = dataPantai.borderColor;

                        var data = labels.map(function(year) {
                            return luasan[year] || 0; // Gunakan 0 jika tidak ada data untuk tahun tersebut
                        });

                        datasets.push({
                            label: pantai,
                            data: data,
                            borderColor: borderColor,
                            borderWidth: 1,
                            fill: false
                        });
                    });

                    if (myChart) {
                        myChart.destroy();
                    }

                    var ctx = document.getElementById('myChart').getContext('2d');
                    myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: datasets
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Luasan (ha)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tahun'
                                    },
                                    ticks: {
                                        autoSkip: false
                                    }
                                }
                            }
                        }
                    });

                    $('#conclusion').attr('hidden', true);

                } else if (pantai_id != 'all' && tahun == 'all') {
                    // Menangani kasus di mana satu pantai dipilih dan semua tahun
                    var data = response.data;
                    var labels = Object.keys(data.luasan_tiap_tahun);
                    var pantai = data.pantai;
                    var luasan_tiap_tahun = Object.values(data.luasan_tiap_tahun);
                    var result = data.result;
                    var borderColor = data.borderColor;
                    var luasan_lapang = data.data_lapang;
                    var lapanganData = [];

                    labels.forEach(function(tahun) {
                        if (luasan_lapang.hasOwnProperty(tahun)) {
                            lapanganData.push(luasan_lapang[tahun]);
                        } else {
                            lapanganData.push(0);
                        }
                    });

                    var chartData = {
                        labels: labels,
                        datasets: [{
                                label: "Luasan Mangrove",
                                data: luasan_tiap_tahun,
                                borderColor: borderColor,
                                borderWidth: 1,
                                fill: false,
                                type: 'line'
                            },
                            {
                                label: "Luasan Lapangan",
                                data: lapanganData,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                                fill: false,
                                type: 'line'
                            }
                        ]
                    };

                    if (result) {
                        var tahun_prediksi = Object.keys(result)[0];
                        if (!labels.includes(tahun_prediksi)) {
                            chartData.labels.push(tahun_prediksi);
                            chartData.datasets[0].data.push(result[tahun_prediksi]);
                            if (luasan_lapang.hasOwnProperty(tahun_prediksi)) {
                                chartData.datasets[1].data.push(luasan_lapang[tahun_prediksi]);
                            } else {
                                chartData.datasets[1].data.push(0);
                            }
                        }
                    }

                    if (myChart) {
                        myChart.destroy();
                    }

                    var ctx = document.getElementById('myChart').getContext('2d');
                    myChart = new Chart(ctx, {
                        type: 'line',
                        data: chartData,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Luasan (ha)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tahun'
                                    },
                                    ticks: {
                                        autoSkip: false
                                    }
                                }
                            }
                        }
                    });

                    var conclusionHTML = response.data.conclusion;
                    $('#text-conclusion').html(conclusionHTML);
                    $('#conclusion').removeAttr('hidden');

                } else if (pantai_id == 'all' && tahun != 'all') {
                    // Menangani kasus di mana semua pantai dipilih untuk satu tahun
                    var pantaiData = response.data;
                    var labels = [];
                    var data = [];

                    pantaiData.forEach(function(dataPantai) {
                        var pantai = dataPantai.pantai;
                        var luasan = dataPantai.luasan_tiap_tahun;

                        labels.push(pantai);
                        data.push(luasan[Object.keys(luasan)[0]]);
                    });

                    if (myChart) {
                        myChart.destroy();
                    }

                    var dataset = {
                        label: 'Luasan Pantai',
                        data: data,
                        borderColor: 'blue',
                        borderWidth: 1
                    };

                    var options = {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Luasan (ha)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Nama Pantai'
                                },
                                ticks: {
                                    autoSkip: false
                                }
                            }
                        }
                    };

                    var ctx = document.getElementById('myChart').getContext('2d');
                    myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [dataset]
                        },
                        options: options
                    });

                    $('#conclusion').attr('hidden', true);
                }
            } else {
                alert('Gagal menghitung rekomendasi.');
            }
        },
        error: function(xhr, status, error) {
            alert('Terjadi kesalahan: ' + error);
        }
    });
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