<?php

namespace App\Http\Controllers;

use App\Models\Pantais;
use Yajra\DataTables\DataTables;
use App\Http\Requests\PantaiRequest;
use App\Models\CitraSatelit;
use App\Models\JenisMangrove;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PantaiStakeholderController extends Controller
{

    public function json()
        {
            $pantais = Pantais::select(['id', 'nama_pantai', 'lokasi_pantai', 'longitude', 'latitude', 'komen', 'image', 'video'])
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
        $validatedData = $request->validate([
            'komen' => 'required',
            'image' => 'nullable|file|max:2048', // Validasi ukuran maksimum gambar
            'video' => 'nullable|file|max:10000',
        ]);

        $pantai = Pantais::findOrFail($id);
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
        $pantai->komen = $validatedData['komen'];
        $pantai->save();

        return redirect('/dashboard_stakeholder/pantai')->with('success', 'Pantai updated successfully.');
    }
}
