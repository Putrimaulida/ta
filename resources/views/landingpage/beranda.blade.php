<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">
    <title>Mangrove.In</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">



    <!-- Favicons logo web -->
    <!-- <link href="assets/img/favicon.png" rel="icon"> -->
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <style>
        .card-container {
            display: flex;
            justify-content: space-between;
        }

        .card {
            flex: 1;
            max-width: 300px;
            /* Lebar maksimum kartu */
            margin: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
            /* Perbesar kartu saat hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Tambahkan bayangan saat hover */
        }

        .card-body {
            text-align: center;
        }

        .card i {
            font-size: 36px;
            margin-bottom: 10px;
            color: #007BFF;
        }

        .btn {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Gaya CSS untuk tombol "Clear" */
        #trackComplaintForm button[type="reset"] {
            background: transparent;
            /* Latar belakang transparan */
            border: none;
            /* Hapus border */
            cursor: pointer;
            /* Tampilkan cursor pointer saat mengarahkan ke tombol */
            margin-left: 10px;
            /* Jarak antara tombol "Track" dan "Clear" */
            font-size: 16px;
            /* Ukuran font teks */
            color: red;
            /* Warna teks (misalnya, merah) */
        }

        /* Gaya CSS untuk menghilangkan efek klik pada tombol "Clear" */
        #trackComplaintForm button[type="reset"]:focus {
            outline: none;
            /* Hapus efek outline saat tombol ditekan */
        }

        .website-link {
            color: #ffD700;
            text-decoration: none;
        }

        .map-controls {
            position: absolute;
            top: 1px;
            right: 1px;
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.8);
            /* Atur opacity background */
            padding: 2px;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            max-width: 200px;
            /* Atur maksimal lebar kontrol */
        }

        #toggleControls {
            font-size: 0.8rem;
            /* Atur ukuran font tombol */
            padding: 1px 1px;
        }

        .input-group,
        .form-check {
            font-size: 0.7rem;
            /* Atur ukuran font elemen input dan label */
        }

        .form-check-input {
            transform: scale(0.7);
            /* Atur ukuran checkbox */
        }

        .d-none {
            display: none;
        }

        .btn i {
            font-size: 1rem;
            margin: 2px;
        }

        /* Styling Container Checkbox */
        .custom-checkbox {
            position: relative;
            padding-left: 25px;
            cursor: pointer;
            font-size: 0.9rem;
            user-select: none;
        }

        /* Hide Checkbox default */
        .custom-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* Style untuk kotak checkbox */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #eee;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Ketika user meng-hover cursor */
        .custom-checkbox:hover input~.checkmark {
            background-color: #ccc;
        }

        /* Style untuk checkbox ketika dicentang */
        .custom-checkbox input:checked~.checkmark {
            background-color: #2196F3;
        }

        /* Membuat tanda centang */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .custom-checkbox input:checked~.checkmark:after {
            display: block;
        }

        .custom-checkbox .checkmark:after {
            left: 7px;
            top: 3px;
            width: 7px;
            height: 13px;
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
        }

        .btn-transparent {
            background-color: transparent;
            border: 2px solid #fff;
            padding: 0;
            /* Menghilangkan padding */
            color: #fff;
            /* Warna teks untuk tombol transparan */
            cursor: pointer;
        }

        /* CSS untuk mengatur lebar maksimum gambar dalam hero section */
        .hero-img img {
            max-width: 100%;
            /* Membatasi lebar gambar agar tidak melebihi lebar container */
            height: auto;
            /* Memastikan tinggi gambar disesuaikan secara proporsional */
        }

        #slider {
            padding: 10px 0 10px;
            position: relative;
            width: 300px;
            height: 300px;
        }

        #slider img {
            width: 300px;
            height: 300px;
            position: absolute;
            -webkit-border-radius: 5px 5px 5px 5px;
            border-radius: 5px;
            -moz-border-radius: 5px 5px 5px 5px;
        }

        .carousel-inner img {
            max-height: 300px;
            /* Sesuaikan tinggi maksimal gambar */
            object-fit: cover;
            /* Menjaga rasio aspek gambar */
        }

        .carousel-control-prev,
        .carousel-control-next {
            top: 50%;
            /* Menyelaraskan tombol di tengah vertikal */
            transform: translateY(-50%);
            width: 5%;
            /* Lebar tombol */
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-size: 100%, 100%;
            /* Ukuran ikon */
        }

        .why-us .accordion-list li {
            padding: none !important;
            background: #fff;
            border-radius: none !important;
            margin-top: 0px !important;
        }
    </style>
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center">

            <h1 class="logo me-auto"><a href="beranda" style="text-decoration: none;">Mangrove.In</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="#about">About</a></li>
                    <li><a class="nav-link scrollto" href="#pantai">Data Pantai</a></li>
                    <li><a class="nav-link scrollto" href="#rekomendasi">Analisis Data</a></li>
                    <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center"
        style="background-image: url('assets/images/mangrove5.jpg');  background-repeat: no-repeat; background-size: cover;">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up" data-aos-delay="200">
                    <h1 style="font-size:34px;">Pengelolaan Vegetasi Mangorve</h1>
                    <h1>Mangrove.In Siap Melayani!</h1>
                    <h2>Informasi Seputar Perkembangan dan Pengelolaan Vegetasi Mangrove Kabupaten Malang Selatan</h2>
                </div>
            </div>
        </div>

    </section><!-- End Hero -->


    <main id="main">

        <!-- ======= Clients Section ======= -->
        <section id="clients" class="clients section-bg">
            <div class="container">

                <div class="row" data-aos="zoom-in">

                </div>

            </div>
        </section><!-- End Cliens Section -->

        <!-- ======= About Us Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>About Us</h2>
                </div>
                <div class="row content">
                    <div class="col-lg-6">
                        <p style="text-align: justify;">
                            Sistem Informasi Pengelolaan Vegetasi Mangrove berkomitmen untuk memberikan layanan terbaik
                            dalam
                            menjaga kelestarian ekosistem wilayah pesisir. Dengan semangat pelayanan yang unggul, kami
                            bertekad untuk
                            meningkatkan kualitas hidup masyarakat melalui aksesibilitas, efisiensi, dan kepedulian
                            terhadap lingkungan.
                        </p>
                        <ul>
                            <li><i class="ri-check-double-line"></i> Pelayanan Unggul: Memberikan layanan dengan
                                profesionalisme, integritas, dan rasa tanggung jawab tinggi.</li>
                            <li><i class="ri-check-double-line"></i> Inovasi: Mengadopsi teknologi dan metode terbaru
                                untuk terus meningkatkan kualitas dan efisiensi layanan.</li>
                            <li><i class="ri-check-double-line"></i> Kolaborasi: Bekerja sama dengan berbagai pihak
                                untuk mencapai tujuan bersama dan mendukung kemajuan masyarakat.</li>
                            <li><i class="ri-check-double-line"></i>Transparansi: Menjaga keterbukaan dalam proses
                                pelayanan dan pengambilan keputusan.</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0">
                        <p style="text-align: justify;">
                            Kami yakin bahwa menangani informasi pengelolaan vegetasi mangrove dengan baik adalah kunci
                            untuk membangun
                            sebuah ekosistem yang ramah lingkungan dan kepedulian masyarakat terhadap lingkungan dapat
                            meningkat. Setiap pengaduan yang kami tangani adalah
                            kontribusi nyata bagi kemajuan masyarakat secara keseluruhan. Informasi ini diharapkan
                            dapat membantu dalam menjaga kelestarian ekosistem ditiap periodenya berdasarkan garis
                            trendnya.
                            Komunikasi yang jujur
                            dan terbuka merupakan dasar bagi hubungan yang kuat antara kami dan masyarakat yang kami
                            layani. Perubahan yang kami ciptakan hari ini adalah investasi bagi masa depan yang lebih
                            baik. Bersama-sama, mari membangun
                            masyarakat yang lebih baik dan sejahtera untuk generasi mendatang. Terima kasih atas
                            dukungan dan kepercayaan Anda dalam sistem pengelolaan vegetasi mangrove ini. Mari
                            bersama-sama
                            menciptakan kelestarian ekositem mangrove yang lebih baik dan memberdayakan seluruh
                            masyarakat
                            untuk mencapai kesejahteraan dan kemajuan bersama.
                        </p>
                        {{-- <a href="#" class="btn-learn-more">Learn More</a> --}}
                    </div>
                </div>

            </div>
        </section><!-- End About Us Section -->

        <section id="pantai" class="why-us section-bg">
            <div class="container-fluid" data-aos="fade-up">
                <div class="row">
                    <!-- Bagian Tengah untuk Data Pantai -->
                    <div class="col-12 text-center">
                        <div class="section-title">
                        <h2>Data Pantai</h2>
                    </div>
                    </div>
                    <!-- Kolom Kiri -->
                    <div class="col-lg-6 d-flex flex-column justify-content-center align-items-stretch order-2 order-lg-1">
                        <div class="accordion-list">
                            <ul>
                                @foreach ($dataPantai->slice(0, ceil($dataPantai->count() / 2)) as $nomor => $pantai)
                                    <li>
                                        <a data-bs-toggle="collapse" class="collapse"
                                            data-bs-target="#accordion-list-{{ $pantai->id }}"
                                            style="text-decoration: none;">
                                            <span>{{ $nomor + 1 }}</span> {{ $pantai->nama_pantai }}
                                            <i class="bx bx-chevron-down icon-show"></i>
                                            <i class="bx bx-chevron-up icon-close"></i>
                                        </a>
                                        <div id="accordion-list-{{ $pantai->id }}" class="collapse" data-bs-parent=".accordion-list">
                                            <p style="text-align: justify;">
                                                Pantai {{ $pantai->nama_pantai }} terletak di {{ $pantai->lokasi_pantai }}. 
                                                Koordinat pantai ini adalah {{ $pantai->latitude }}° LS dan {{ $pantai->longitude }}° BT.
                                                Jenis-jenis mangrove yang terdapat pada {{ $pantai->nama_pantai }} antara lain:
                                                @foreach ($pantai->jenisMangroves as $jenisMangrove)
                                                    {{ $jenisMangrove->nama_ilmiah }}{{ !$loop->last ? ',' : '.' }}
                                                @endforeach
                                                {{ $pantai->komen ? 'Keterangan: ' . $pantai->komen . '.' : '' }}
                                            </p>
                                            @if ($pantai->pantaiImages)
                                                <div id="carouselExampleIndicators-{{ $pantai->id }}" class="carousel slide" data-bs-ride="carousel" style="max-width: 100%;">
                                                    <ol class="carousel-indicators">
                                                        @foreach ($pantai->pantaiImages as $listfoto)
                                                            <li data-bs-target="#carouselExampleIndicators-{{ $pantai->id }}" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                                                        @endforeach
                                                    </ol>
                                                    <div class="carousel-inner">
                                                        @foreach ($pantai->pantaiImages as $listfoto)
                                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                                <img class="d-block w-100" style="height: 350px; object-fit: contain;" src="{{ asset('storage/' . $listfoto->path) }}" alt="Gambar Pantai">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- Kolom Kanan -->
                    <div class="col-lg-6 d-flex flex-column justify-content-center align-items-stretch order-2 order-lg-1">
                        <div class="accordion-list">
                            <ul>
                                @php $offset = ceil($dataPantai->count() / 2); @endphp
                                @foreach ($dataPantai->slice($offset) as $nomor => $pantai)
                                    <li>
                                        <a data-bs-toggle="collapse" class="collapse"
                                            data-bs-target="#accordion-list-{{ $pantai->id }}"
                                            style="text-decoration: none;">
                                            <span>{{ $nomor + 1 }}</span> {{ $pantai->nama_pantai }}
                                            <i class="bx bx-chevron-down icon-show"></i>
                                            <i class="bx bx-chevron-up icon-close"></i>
                                        </a>
                                        <div id="accordion-list-{{ $pantai->id }}" class="collapse" data-bs-parent=".accordion-list">
                                            <p style="text-align: justify;">
                                                Pantai {{ $pantai->nama_pantai }} terletak di {{ $pantai->lokasi_pantai }}. 
                                                Koordinat pantai ini adalah {{ $pantai->latitude }}° LS dan {{ $pantai->longitude }}° BT.
                                                Jenis-jenis mangrove yang terdapat pada {{ $pantai->nama_pantai }} antara lain:
                                                @foreach ($pantai->jenisMangroves as $jenisMangrove)
                                                    {{ $jenisMangrove->nama_ilmiah }}{{ !$loop->last ? ',' : '.' }}
                                                @endforeach
                                                {{ $pantai->komen ? 'Keterangan: ' . $pantai->komen . '.' : '' }}
                                            </p>
                                            @if ($pantai->pantaiImages)
                                                <div id="carouselExampleIndicators-{{ $pantai->id }}" class="carousel slide" data-bs-ride="carousel" style="max-width: 100%;">
                                                    <ol class="carousel-indicators">
                                                        @foreach ($pantai->pantaiImages as $listfoto)
                                                            <li data-bs-target="#carouselExampleIndicators-{{ $pantai->id }}" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                                                        @endforeach
                                                    </ol>
                                                    <div class="carousel-inner">
                                                        @foreach ($pantai->pantaiImages as $listfoto)
                                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                                <img class="d-block w-100" style="height: 350px; object-fit: contain;" src="{{ asset('storage/' . $listfoto->path) }}" alt="Gambar Pantai">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="rekomendasi" class="contact">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Hasil Analisis</h2>
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
                            <button type="submit" onclick="countRekomendasi()"
                                class="btn btn-primary">Kirim</button>
                        </div>
                    </div>

                    <script>
                        var myChart;

                        function countRekomendasi() {
                            var pantai_id = $('#pantai_id').val();
                            var tahun = $('#tahun').val();

                            if (pantai_id == 'all') {
                                $.ajax({
                                    url: "{{ route('countRecommendedBeranda') }}",
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
                                                            text: 'Luasan (km²)'
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
                                        } else {
                                            alert('Gagal menghitung rekomendasi.');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        alert('Terjadi kesalahan: ' + error);
                                    }
                                });
                            } else {
                                if (tahun == 'all') {
                                    $.ajax({
                                        url: "{{ route('countRecommendedBeranda') }}",
                                        type: "POST",
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            "pantai_id": pantai_id,
                                            "tahun": tahun
                                        },
                                        success: function(response) {
                                            if (response.success == true) {
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
                                                            chartData.datasets[1].data.push(
                                                                0);
                                                        }
                                                    }
                                                }

                                                myChart.data = chartData;
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
                                } else {
                                    $.ajax({
                                        url: "{{ route('countRecommendedBeranda') }}",
                                        type: "POST",
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            "pantai_id": pantai_id,
                                            "tahun": tahun
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
        </section><!-- End Team Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">

        {{-- <div class="footer-newsletter">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h4>Lacak Status Pengaduanmu</h4>
                        <p style="text-align:justify">Fitur ini memungkinkan pengguna untuk mengikuti dan memantau
                            perkembangan pengaduan yang telah mereka ajukan. Dengan demikian, pengguna dapat dengan
                            mudah mengetahui status dan tahapan penanganan pengaduan mereka, menciptakan transparansi
                            dan keterlibatan dalam proses tersebut.</p>
                        <form id="trackComplaintForm" action="{{ route('track.complaint') }}" method="post">
        @csrf
        <input type="text" name="code_ticket" placeholder="Enter Code Number" required>
        <button type="reset"><i class="fas fa-times"></i></button>
        <!-- Tombol Clear dengan ikon Font Awesome "times" -->
        <button type="submit">Track</button>
        </form>
        </div>
        </div>
        </div>
        </div> --}}

        <div class="footer-top">
            <div class="container" class="why-us section-bg">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mx-auto text-center">
                        <h4>Mangrove.In</h4>
                        <p>
                            Jl. Raya Raci Km. 09 <br>
                            Malang Kabupaten - Pemerintah Kabupaten Malang 671115<br>
                            Indonesia <br><br>
                            <strong>Telepon/Fax:</strong> 0343429064<br>
                            <strong>Email:</strong> mangrovein@malangkab.go.id<br>
                        </p>
                    </div>

                    {{-- <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                        </ul>
                    </div> --}}

                    <div class="col-lg-3 col-md-6 mx-auto text-center">
                        <h4>Temukan Kami di Media Sosial</h4>
                        <p>Ikuti kami untuk informasi terbaru dan interaksi lebih lanjut.</p>
                        <div class="social-links mt-3">
                            <a href="https://www.twitter.com/pemkabpasuruan_" class="twitter"><i
                                    class="bx bxl-twitter"></i></a>
                            <a href="https://www.facebook.com/pasuruankab.go.id/" class="facebook"><i
                                    class="bx bxl-facebook"></i></a>
                            <a href="https://www.instagram.com/pemkabpasuruan/" class="instagram"><i
                                    class="bx bxl-instagram"></i></a>
                            <a href="https://www.youtube.com/@ILOVEPASTV" class="google-plus"><i
                                    class="bx bxl-youtube"></i></a>
                            {{-- <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a> --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container footer-bottom clearfix">
            <div class="copyright">
                &copy; Copyright <strong><span>Mangrove.In 2024</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <a href="" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Tombol "like" -->
    <!-- Tombol "like" -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {

            // Fungsi doAction() digunakan untuk melakukan tindakan (like atau dislike) pada suatu polling.
            function doAction(action, pollId) {
                $.ajax({
                    // Mengirim permintaan AJAX ke URL yang sesuai dengan tindakan dan ID polling.
                    url: `/poll/${action}/${pollId}`,
                    type: 'POST', // Menggunakan metode HTTP POST.
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Mengirim token CSRF untuk keamanan.
                    },
                    dataType: 'json', // Mengharapkan respons berupa JSON.
                    success: function(data) {
                        // Ketika permintaan berhasil, pembaruan tampilan dilakukan.
                        $('#likesCount' + pollId).text(data.likes); // Memperbarui jumlah suka.
                        $('#dislikesCount' + pollId).text(data
                            .dislikes); // Memperbarui jumlah tidak suka.

                        // Memuat ulang halaman (reloading) untuk menampilkan pembaruan secara lengkap.
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Ketika terjadi kesalahan, pesan kesalahan ditampilkan.
                        console.error(xhr.responseText); // Menampilkan pesan kesalahan di konsol.
                        alert(
                            "An error occurred. Please try again."
                        ); // Menampilkan pesan kesalahan kepada pengguna.
                    }
                });
            }

            // Mengatur event click untuk tombol "Like" pada polling.
            $(document).on('click', '.btn-like', function(event) {
                event.preventDefault(); // Mencegah tindakan default dari tautan.
                var pollId = $(this).data('poll-id'); // Mendapatkan ID polling dari atribut data.
                doAction('like', pollId); // Memanggil fungsi doAction() dengan tindakan 'like'.
            });

            // Mengatur event click untuk tombol "Dislike" pada polling.
            $(document).on('click', '.btn-dislike', function(event) {
                event.preventDefault(); // Mencegah tindakan default dari tautan.
                var pollId = $(this).data('poll-id'); // Mendapatkan ID polling dari atribut data.
                doAction('dislike', pollId); // Memanggil fungsi doAction() dengan tindakan 'dislike'.
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Ketika halaman telah sepenuhnya dimuat, kita akan menjalankan kode berikutnya.
        document.addEventListener("DOMContentLoaded", function() {
            // Mencari tombol yang akan menutup modal dan menyimpannya dalam variabel.
            let closeModalButton1 = document.querySelector('#closeModalButton');

            // Mencari semua tautan dengan kelas CSS "show-tugas" dan menyimpannya dalam variabel.
            let links = document.querySelectorAll('.show-tugas');

            // Mencari elemen modal dengan ID "tugasModal" dan menyimpannya dalam variabel.
            let modal = document.querySelector('#tugasModal');

            // Mencari judul modal di dalam elemen modal dan menyimpannya dalam variabel.
            let modalTitle = modal.querySelector('.modal-title');

            // Mengatur event click untuk tombol-tutup-modal dan tombol "X".
            $('#closeModalButton1, #closeModalX1').click(function() {
                // Ketika tombol ini diklik, modal akan disembunyikan.
                $('#tugasModal').modal('hide');
            });

            // Mengatur event click untuk setiap tautan yang memicu modal.
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Mencegah tindakan default (navigasi tautan).
                    e.preventDefault();

                    // Mengambil ID departemen dari data atribut tautan yang diklik.
                    let departementId = this.getAttribute('data-id');

                    // Mengambil informasi tentang departemen dari API backend.
                    // Data ini berisi daftar tugas departemen.
                    fetch('/api/departements/' + departementId)
                        .then(response => response.json())
                        .then(data => {
                            // Mengosongkan konten modal.
                            let modalBody = modal.querySelector('.modal-body');
                            modalBody.innerHTML = '';

                            // Menambahkan tugas-tugas departemen ke dalam modal.
                            data.tugas.forEach(tugas => {
                                modalBody.innerHTML += '<p>' + tugas + '</p>';
                            });

                            // Add the website link to the modal body
                            // if (data.link_website) {
                            //     modalBody.innerHTML +=
                            //         '<div class="text-center mt-3"><a href="' + data
                            //         .link_website + '" target="_blank">Visit Website</a></div>';
                            // }
                            // Menambahkan class CSS ke elemen HTML yang Anda buat
                            if (data.linkWebsite) {
                                modalBody.innerHTML +=
                                    '<div class="text-center mt-3"><a href="' + data
                                    .linkWebsite +
                                    '" target="_blank" class="website-link">Visit Website</a></div>';
                            }
                            // Memperbarui judul modal dengan nama departemen.
                            modalTitle.textContent = 'TUGAS (' + data.name + ')';

                            // Menampilkan modal kepada pengguna.
                            $(modal).modal('show');
                        });
                });
            });

            // Fungsi ini seharusnya digunakan jika ingin menutup modal secara program,
            // meskipun tidak digunakan dalam kode ini.
            function closeModal() {
                $(modal).modal('hide');
            }
        });
    </script>
    {{-- <script src="path_to_bootstrap_js"></script> --}}
    <!-- Vendor JS Files -->
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    @include('landingpage.trackticketjs')
</body>

</html>
