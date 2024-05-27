<?php

namespace App\Http\Controllers;

use App\Models\Pantais;
use Yajra\DataTables\DataTables;
use App\Http\Requests\PantaiRequest;
use App\Models\CitraSatelit;
use App\Models\JenisMangrove;
use App\Models\PantaiImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PantaiStakeholderController extends Controller
{

    public function json()
        {
            $pantais = Pantais::select(['id', 'nama_pantai', 'lokasi_pantai', 'longitude', 'latitude'])
                ->get();
            $index = 1;
            return DataTables::of($pantais)
                ->addColumn('DT_RowIndex', function ($data) use (&$index) {
                    return $index++; // Menambahkan nomor urutan baris
                })
                ->addColumn('action', function ($row) {
                    $editUrl = url('/dashboard_stakeholder/pantai/edit/' . $row->id);
                    $viewUrl = url('/dashboard_stakeholder/pantai/view/' . $row->id);
                    return '<button type="button" class="btn btn-warning btn-sm" onclick="window.location.href=\'' . $editUrl . '\'"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-info btn-sm" onclick="window.location.href=\'' . $viewUrl . '\'"><i class="fas fa-list"></i></button>';
                    // Tukar posisi tombol view dengan tombol delete
                })
                ->toJson();
        }

    public function index()
    {
        return view('stakeholder.pantai.index');
    }

    public function show($id)
    {
        $pantai = Pantais::findOrFail($id);
        $pantai_id = $pantai->pluck('id')->first();
        return view('stakeholder.pantai.detail', compact('pantai','pantai_id'));
    }

    public function showcitra($id)
    {
        $pantai = Pantais::findOrFail($id);
        $citra = CitraSatelit::where('id',$pantai->id)->first();
        return view('stakeholder.pantai.detail', compact('pantai'));
    }

    // menampilkan view update
    public function edit($id)
    {
        $pantai = Pantais::findOrFail($id);
        return view('stakeholder.pantai.edit', compact('pantai'));
    }
    
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'komen' => 'required',
            'image.*' => 'nullable|file|max:2048', // Validasi ukuran maksimum gambar
            'video' => 'required|string', // Validasi ukuran maksimum video
        ]);

        $pantai = Pantais::findOrFail($id);
        $pantai->komen = $validatedData['komen'];

        // Periksa apakah gambar baru dikirim
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            $imagePantai = PantaiImage::where('pantai_id', $pantai->id)->get();
            foreach ($imagePantai as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }

            // Upload gambar baru
            foreach ($request->file('image') as $file) {
                $imagePath = $file->store('images_pantai', 'public');
                PantaiImage::create([
                    'path' => $imagePath,
                    'pantai_id' => $pantai->id
                ]);
            }
        }

        $pantai->save();

        return redirect('/dashboard_stakeholder/pantai')->with('success', 'Komen berhasil dikirim.');
    }
}