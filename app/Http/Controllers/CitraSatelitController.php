<?php

namespace App\Http\Controllers;

use App\Models\CitraSatelit;
use App\Http\Requests\CitraSatelitRequest;
use App\Models\Pantais;
use Yajra\DataTables\DataTables;

class CitraSatelitController extends Controller
{
    /**
     * Menampilkan daftar jenis mangrove.
     *
     * @return \Illuminate\Http\Response
     */

     public function json1($id)
    {
        // where id pantai to id satelit
        //menampilkan data satelit berdasarkan id pantai
        // menambahkan fungsi untuk menyambungkan klik disini bisa get
        $users = CitraSatelit::select(['id', 'tahun', 'luasan', 'pantai_id'])
            ->with('pantai:id,nama_pantai') // Load relasi pantai
            ->where('pantai_id', $id)
            ->get();

        $index = 1;
        return DataTables::of($users)
            ->addColumn('DT_RowIndex', function ($data) use (&$index) {
                return $index++; // Menambahkan nomor urutan baris
            })
            ->addColumn('action', function ($row) {
            })
            ->toJson();
    }

    public function citraPantai($id){
        $pantai = Pantais::findOrFail($id);
        $pantai_id = $pantai->id;
        return view('admin.citra.detail', compact('pantai','pantai_id'));
    }
    
    public function json()
    {
        $users = CitraSatelit::select(['id', 'tahun', 'luasan', 'pantai_id'])
        ->with('pantai:id,nama_pantai') // Load relasi pantai
        ->get();
         $index = 1;
         return DataTables::of($users)
             ->addColumn('DT_RowIndex', function ($data) use (&$index) {
                 return $index++; // Menambahkan nomor urutan baris
             })
             ->addColumn('action', function ($row) {
                 $editUrl = url('/dashboard_admin/citra/edit/' . $row->id);
                 $deleteUrl = url('/dashboard_admin/citra/destroy/' . $row->id);
                 return '<button type="button" class="btn btn-primary" onclick="window.location.href=\'' . $editUrl . '\'"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-danger delete-users" data-url="' . $deleteUrl . '"><i class="fas fa-trash-alt"></i></button>';
             })
             ->toJson();
    }
     

    public function index()
    {
        $citraSatelits = CitraSatelit::all();
        return view('admin.citra.index', compact('citraSatelits'));
    }

    /**
     * Menampilkan formulir untuk membuat jenis mangrove baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dataPantai = Pantais::pluck('nama_pantai', 'id');
        return view('admin.citra.create', compact('dataPantai'));
    }


    /**
     * Menyimpan jenis mangrove yang baru dibuat ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CitraSatelitRequest $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'luasan' => 'required|numeric',
            'pantai_id' => 'required|exists:pantais,id', // Pastikan pantai_id ada di tabel pantais
        ]);

        // Periksa apakah kombinasi pantai_id dan tahun sudah ada
        if (CitraSatelit::where('pantai_id', $request->pantai_id)
                        ->where('tahun', $request->tahun)
                        ->exists()) {
            return redirect()->back()->withErrors(['error' => 'Data citra satelit dengan pantai dan tahun tersebut sudah ada.'])->withInput();
        }

        CitraSatelit::create([
            'tahun' => $request->tahun,
            'luasan' => $request->luasan,
            'pantai_id' => $request->pantai_id,
        ]);

        return redirect()->route('admin.citra')
                        ->with('success', 'Citra Satelit berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit citra satelit.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataCitra = CitraSatelit::findOrFail($id);
        $dataPantai = Pantais::pluck('nama_pantai', 'id'); // Mengambil daftar pantai untuk dropdown
    
        return view('admin.citra.edit', compact('dataCitra', 'dataPantai'));
    }

    /**
     * Memperbarui citra satelit yang telah ada di dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CitraSatelitRequest $request, $id)
    {
        $request->validate([
            'pantai_id' => 'required|exists:pantais,id', // Pastikan pantai_id ada di tabel pantais
            'tahun' => 'required|integer',
            'luasan' => 'required|numeric',
        ]);

        $dataCitra = CitraSatelit::findOrFail($id);

        // Periksa apakah kombinasi pantai_id dan tahun sudah ada, kecuali data saat ini
        if (CitraSatelit::where('pantai_id', $request->pantai_id)
                        ->where('tahun', $request->tahun)
                        ->where('id', '!=', $id)
                        ->exists()) {
            return redirect()->back()->withErrors(['error' => 'Data citra satelit dengan pantai dan tahun tersebut sudah ada.'])->withInput();
        }

        $dataCitra->pantai_id = $request->input('pantai_id');
        $dataCitra->tahun = $request->input('tahun');
        $dataCitra->luasan = $request->input('luasan');
        $dataCitra->save();

        return redirect()->route('admin.citra')->with('success', 'Data citra berhasil diupdate!');
    }

    /**
     * Menghapus citra satelit dari database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $citraSatelit = CitraSatelit::findOrFail($id);
        $citraSatelit->delete();
        return response()->json(['success' => 'Citra Satelit deleted successfully.']);
    }

    public function view($id)
    {
        $citraSatelit = CitraSatelit::findOrFail($id);
        return view('admin.citra.view', compact('citraSatelit'));
    }
}
