<?php

namespace App\Http\Controllers;

use App\Models\JenisMangrove;
use App\Models\User;
use App\Models\Pantais;

class DashboardAdminController extends Controller
{
    public function index(){
        // Mendapatkan jumlah total pengguna pengguna yang sudah terdaftar
        $totalPengguna = User::select(['id', 'name', 'email'])
            ->where('role', 'stakeholder')
            ->get();
        $totalCount = $totalPengguna->count();

        $totalPantai = Pantais::select(['id', 'nama_pantai', 'lokasi_pantai', 'longitude', 'latitude'])
        ->get();
        $totalCountPantai = $totalPantai->count();

        $totalMangrove = JenisMangrove::select(['id', 'nama_keluarga', 'nama_ilmiah'])
        ->get();
        $totalCountMangrove = $totalMangrove->count();

        return view('admin.dashboard.index', compact('totalCount', 'totalCountPantai', 'totalCountMangrove'));

    }
}
