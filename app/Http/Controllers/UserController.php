<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserUpdateRequest;
use Alert;
use Illuminate\Support\Facades\Response; // Tambahkan ini pada bagian atas file controller

class UserController extends Controller
{
    public function edit()
    {
        // Mendapatkan pengguna yang saat ini terotentikasi
        $user = auth()->user();

        // Tampilkan halaman edit untuk pengguna dengan role "user"
        return view('admin.profile.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request)
    {
        // Mendapatkan data yang valid dari permintaan (request) pengguna
        $data = $request->validated();

        // Mendapatkan pengguna yang saat ini terotentikasi
        $user = auth()->user();

        // Membuat koleksi dari field yang ingin kita cek.
        $unchanged = collect(['name', 'email', 'password'])->every(function ($field) use ($data, $user) {
            // Untuk setiap field, periksa apakah field tersebut tidak ada dalam data yang diberikan
            // atau jika field tersebut sama dengan yang ada di database.
            // Jika field adalah 'password', kita perlu memeriksa apakah password dari request setelah di-hash sama dengan yang ada di database.
            return !isset($data[$field]) || ($field === 'password' ? \Hash::check($data[$field], $user->$field) : $data[$field] === $user->$field);
        });

        // Jika semua field tidak berubah (yaitu, semua field sama dengan yang ada di database),
        // kembalikan respons dengan 'success' => false.
        if ($unchanged) {
            return Response::json(['success' => false]);
        }

        // Memeriksa apakah ada perubahan password dan mengenkripsi password baru jika ada
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        // Mengatur peran pengguna sebagai "user"
        $data['role'] = 'user';

        // Memperbarui data profil pengguna dengan data yang telah diubah
        $user->update($data);

        // Jika perubahan profil berhasil, kirimkan respons JSON ke klien
        return Response::json(['success' => true]);
    }

    public function delete(Request $request)
    {
        // Mendapatkan pengguna yang saat ini terotentikasi
        $user = auth()->user();

        // Menghapus pengguna dari database
        $user->delete();

        // Memberikan respons ke klien
        return Response::json(['success' => true, 'message' => 'User berhasil dihapus']);
    }

}