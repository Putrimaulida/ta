<?php

namespace App\Http\Controllers;

use App\Models\Pantais;
use Yajra\DataTables\DataTables;
use App\Http\Requests\PantaiRequest;
use App\Models\CitraSatelit;
use App\Models\JenisMangrove;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PantaiController extends Controller
{
    public function json()
    {
        $pantais = Pantais::select(['id', 'nama_pantai', 'lokasi_pantai', 'longitude', 'latitude', 'komen', 'image', 'video'])->get();
        $index = 1;
        return DataTables::of($pantais)
            ->addColumn('DT_RowIndex', function ($data) use (&$index) {
                return $index++; // Menambahkan nomor urutan baris
            })
            ->addColumn('action', function ($row) {
                $editUrl = url('/dashboard_admin/pantai/edit/' . $row->id);
                $viewUrl = url('/dashboard_admin/pantai/view/' . $row->id);
                $deleteUrl = url('/dashboard_admin/pantai/destroy/' . $row->id);
                $accUrl = url('/dashboard_admin/pantai/verifikasilaporan/' . $row->id);
                return '<button type="button" class="btn btn-warning btn-sm mb-2" onclick="window.location.href=\'' . $editUrl . '\'"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-info btn-sm mb-2" onclick="window.location.href=\'' . $viewUrl . '\'"><i class="fas fa-list"></i></button>
                        <button type="button" class="btn btn-danger btn-sm delete-users mb-2" data-url="' . $deleteUrl . '"><i class="fas fa-trash-alt"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="window.location.href=\'' . $accUrl . '\'"><i class="fas fa-check"></i></button>';
            })
            ->toJson();
    }

    public function index()
    {
        return view('admin.pantai.index');
    }
    public function create()
    {
        $jenisMangrove = JenisMangrove::pluck('nama_ilmiah', 'id');
        return view('admin.pantai.create', compact('jenisMangrove'));
    }

    public function store(PantaiRequest $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_pantai' => 'required|string',
            'lokasi_pantai' => 'required|string',
            'longitude' => 'required|string',
            'latitude' => 'required|string',
            'jenis_mangrove_id' => 'required|array', // Tipe data array
            'jenis_mangrove_id.*' => 'exists:jenis_mangroves,id', // Pastikan semua nilai ada di tabel jenis_mangroves
            'image' => 'required|file|max:2048', // Validasi ukuran maksimum gambar
            'video' => 'required|file|max:10000', // Validasi ukuran maksimum video
        ]);

        // Cek apakah nama pantai sudah ada
        if (Pantais::where('nama_pantai', $validatedData['nama_pantai'])->exists()) {
            return redirect()->back()->withErrors(['nama_pantai' => 'Nama pantai sudah terdaftar.'])->withInput();
        }

        // Mengunggah file gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images_pantai', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Mengunggah file video
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('videos_pantai', 'public');
            $validatedData['video'] = $videoPath;
        }

        // Tambahkan data pantai
        $pantai = Pantais::create([
            'nama_pantai' => $validatedData['nama_pantai'],
            'lokasi_pantai' => $validatedData['lokasi_pantai'],
            'longitude' => $validatedData['longitude'],
            'latitude' => $validatedData['latitude'],
            'image' => $validatedData['image'],
            'video' => $validatedData['video'],
            'status' => 0,
        ]);

        // Synchronize jenis mangrove
        $pantai->jenisMangroves()->attach($validatedData['jenis_mangrove_id']);

        // Berikan respons yang sesuai
        return redirect('/dashboard_admin/pantai')->with('success', 'Data pantai berhasil ditambahkan.');
    }

    public function show($id)
    {
        $pantai = Pantais::findOrFail($id);
        $pantai_id = $pantai->pluck('id')->first();
        return view('admin.pantai.show', compact('pantai','pantai_id'));
    }

    public function showcitra($id)
    {
        $pantai = Pantais::findOrFail($id);
        $citra = CitraSatelit::where('id',$pantai->id)->first();
        return view('admin.pantai.show', compact('pantai'));
    }

    // menampilkan view update
    public function edit($id)
    {
        $pantai = Pantais::findOrFail($id);
        $jenisMangrove = JenisMangrove::pluck('nama_ilmiah', 'id');
        return view('admin.pantai.edit', compact('pantai', 'jenisMangrove'));
    }

    public function verifikasi($id)
    {
        $pantai = Pantais::findOrFail($id);
        return view('admin.pantai.verifikasi', compact('pantai'));
    }
    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_pantai' => 'required',
            'lokasi_pantai' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'image' => 'nullable|file|max:2048', // Validasi ukuran maksimum gambar
            'video' => 'nullable|file|max:10000',
            'jenis_mangrove_id' => 'required|array', // Tipe data array
            'jenis_mangrove_id.*' => 'exists:jenis_mangroves,id', // Pastikan semua nilai ada di tabel jenis_mangroves
        ]);

        $pantai = Pantais::findOrFail($id);
        $pantai->nama_pantai = $validatedData['nama_pantai'];
        $pantai->lokasi_pantai = $validatedData['lokasi_pantai'];
        $pantai->longitude = $validatedData['longitude'];
        $pantai->latitude = $validatedData['latitude'];

        // Periksa apakah gambar baru dikirim
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($pantai->image);
            $imagePath = $request->file('image')->store('images_pantai', 'public');
            $pantai->image = $imagePath;
            //dd($imagePath);
        }

        // Periksa apakah video baru dikirim
        if ($request->hasFile('video')) {
            Storage::disk('public')->delete($pantai->video);
            $videoPath = $request->file('video')->store('videos_pantai', 'public');
            $pantai->video = $videoPath;
            //dd($videoPath);
        }
        $pantai->jenisMangroves()->sync($validatedData['jenis_mangrove_id']);
        //dd($request->all());
        $pantai->save();

        return redirect('/dashboard_admin/pantai')->with('success', 'Pantai updated successfully.');
    }

    public function verifikasiLaporan(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required',
        ]);

        $pantai = Pantais::findOrFail($id);
        $pantai->status = $validatedData['status'];
        $pantai->save();

        return redirect('/dashboard_admin/pantai')->with('success', 'Verifikasi successfully.');
    }

    public function destroy(string $id)
    {
        $pantai = Pantais::findOrFail($id);
        $pantai->delete();
        return response()->json(['success' => 'Pantai deleted successfully.']);
    }
}
