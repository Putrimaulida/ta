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
                            <img src="{{ asset('storage/' . $pantai->image) }}" alt="Gambar Pantai" width="300">
                            <p><strong></strong></p>
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