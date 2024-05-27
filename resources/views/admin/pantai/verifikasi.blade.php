@extends('admin.layouts.main')
@section('container')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verifikasi Laporan</div>

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

                    <form method="POST" action="{{ url('/dashboard_admin/pantai/verifikasikomen/'.$pantai->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Nama Pantai -->
                        <div class="form-group">
                            <label for="komen">Laporan dari Stakeholder:</label>
                            <input type="text"  class="form-control" value="{{ $pantai->komen }}" readonly>
                        </div>
                        <div class="form-group">
                        <p><strong>Gambar:</strong></p>
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
                            <p><strong>Video:</strong></p>
                            <video controls width="300" height="auto">
                                <source src="{{ asset('storage/' . $pantai->video) }}" type="video/mp4">
                                Browser Anda tidak mendukung tag video.
                            </video>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label><br>
                            <input type="radio" id="diterima" name="status" value="1" {{ $pantai->status == 1 ? 'checked' : '' }}>
                            <label for="diterima">Diterima</label><br>
                            <input type="radio" id="ditolak" name="status" value="2" {{ $pantai->status == 2 ? 'checked' : '' }}>
                            <label for="ditolak">Ditolak</label><br>
                        </div>
                        <!-- Submit Button -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{ url('/dashboard_admin/pantai') }}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection