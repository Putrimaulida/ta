@extends('stakeholder.layouts.main')
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

                    <form method="POST" action="{{ url('/dashboard_stakeholder/pantai/update/'.$pantai->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="komen">Komen:</label>
                            <input type="text" name="komen" id="komen" class="form-control" value="{{ $pantai->komen }}" required>
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
                            <!-- Submit Button -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{ url('/dashboard_stakeholder/pantai') }}" class="btn btn-secondary">Back</a>
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
@endsection