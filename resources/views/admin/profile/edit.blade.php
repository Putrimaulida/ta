@extends('admin.layouts.main')
@section('container')
    <style>
        /* Gaya untuk card */
        .card {
            border: none;
            box-shadow: 0 10px 12px rgba(0, 0, 0, 0.6);
        }

        /* Gaya untuk card header */
        .card-header {
            background-color: #365DCD;
            color: #fff;
        }

        /* Gaya untuk tombol "Kembali" */
        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #545b62;
        }

        /* Gaya untuk tombol "Simpan Perubahan" */
        .btn-primary {
            background-color: #007BFF;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Gaya untuk checkbox "Tampilkan Password" */
        #showPassword {
            margin-left: 10px;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Profil</div>

                    <div class="card-body">
                        <form id="profile-update-form" method="POST"
                            action="{{ route('admin.profile.edit', ['id' => $user->id]) }}"
                            onsubmit="event.preventDefault(); handleProfileUpdate();">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nama</label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        autocomplete="new-password">

                                    <!-- Checkbox untuk menampilkan/sembunyikan password -->
                                    <input type="checkbox" id="showPassword"> Tampilkan Password

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section> <!-- Pastikan penutup section ada di sini -->

    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> --}}
    <script>
        // Fungsi untuk menampilkan SweetAlert
        function showSweetAlert(title, text, icon) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
            });
        }

        function showDashboardSuccessPopup() {
            const popup = document.getElementById('dashboard-success-popup');
            popup.style.display = 'block';

            // Sembunyikan pop-up setelah beberapa detik (misalnya, 3 detik)
            setTimeout(() => {
                popup.style.display = 'none';
            }, 3000); // 3000 milidetik = 3 detik
        }
        // Fungsi untuk menangani permintaan HTTP dengan menggunakan Fetch API
        function handleProfileUpdate() {
            const form = document.getElementById('profile-update-form');
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json()) // Parse respons sebagai JSON
                .then(data => {
                    if (data.success) {
                        // Tampilkan SweetAlert dengan pesan sukses
                        showSweetAlert('Hore!', 'Profil berhasil diperbarui.', 'success');
                        // Redirect to the dashboard after a short delay
                        setTimeout(() => {
                            window.location.href = '{{ route('admin.dashboard') }}';
                        }, 2000); // 2000 milidetik = 2 detik
                    } else {
                        // Tampilkan SweetAlert dengan pesan error jika ada kesalahan
                        showSweetAlert('Oops!', 'Terjadi kesalahan saat memperbarui profil.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
        document.getElementById('showPassword').addEventListener('change', function() {
            const passwordInput = document.getElementById('password');
            if (this.checked) {
                passwordInput.type = 'text'; // Tampilkan password
            } else {
                passwordInput.type = 'password'; // Sembunyikan password
            }
        });
    </script>
@endsection