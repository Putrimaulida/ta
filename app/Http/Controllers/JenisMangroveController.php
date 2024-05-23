<?php

namespace App\Http\Controllers;

use App\Models\JenisMangrove;
use App\Http\Requests\JenisMangroveRequest;
use Yajra\DataTables\DataTables;

class JenisMangroveController extends Controller
{
    /**
     * Menampilkan daftar jenis mangrove.
     *
     * @return \Illuminate\Http\Response
     */
    
     public function json()
     {
         $users = JenisMangrove::select(['id', 'nama_keluarga', 'nama_ilmiah'])
             ->get();
         $index = 1;
         return DataTables::of($users)
             ->addColumn('DT_RowIndex', function ($data) use (&$index) {
                 return $index++; // Menambahkan nomor urutan baris
             })
             ->addColumn('action', function ($row) {
                 $editUrl = url('/dashboard_admin/jenis_mangrove/edit/' . $row->id);
                 $deleteUrl = url('/dashboard_admin/jenis_mangrove/destroy/' . $row->id);
                 return '<button type="button" class="btn btn-primary" onclick="window.location.href=\'' . $editUrl . '\'"><i class="fas fa-edit"></i></button> 
                 <button type="button" class="btn btn-danger delete-users" data-url="' . $deleteUrl . '"><i class="fas fa-trash-alt"></i></button>';
             })
             ->toJson();
     }
     

    public function index()
    {
        $jenisMangroves = JenisMangrove::all();
        return view('admin.mangrove.index', compact('jenisMangroves'));
    }

    /**
     * Menampilkan formulir untuk membuat jenis mangrove baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenisMangroves = JenisMangrove::select('nama_keluarga')->distinct()->get();
        return view('admin.mangrove.create', compact('jenisMangroves'));
    }
    

    /**
     * Menyimpan jenis mangrove yang baru dibuat ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JenisMangroveRequest $request)
    {
        $validatedData = $request->validated();

        // Periksa apakah nama ilmiah sudah ada
        if (JenisMangrove::where('nama_ilmiah', $validatedData['nama_ilmiah'])->exists()) {
            return redirect()->back()->withErrors(['error' => 'Nama ilmiah tersebut sudah ada.'])->withInput();
        }

        // Tentukan nama_keluarga yang akan digunakan
        $nama_keluarga = $validatedData['nama_keluarga_select'] ?? $validatedData['nama_keluarga_manual'];

        JenisMangrove::create([
            'nama_keluarga' => $nama_keluarga,
            'nama_ilmiah' => $validatedData['nama_ilmiah'],
        ]);

        return redirect()->route('admin.mangrove')
                        ->with('success', 'Jenis Mangrove berhasil ditambahkan.');
    }
    
    public function edit($id)
    {
        $jenisMangrove = JenisMangrove::findOrFail($id);
        $jenisMangroves = JenisMangrove::select('nama_keluarga')->distinct()->get(); // Mengambil data nama_keluarga yang unik
        return view('admin.mangrove.edit', compact('jenisMangrove', 'jenisMangroves'));
    } 

    public function update(JenisMangroveRequest $request, $id)
    {
        $validatedData = $request->validated();

        $jenisMangrove = JenisMangrove::findOrFail($id);

        // Periksa apakah nama ilmiah sudah ada, kecuali untuk data saat ini
        if (JenisMangrove::where('nama_ilmiah', $validatedData['nama_ilmiah'])->where('id', '!=', $id)->exists()) {
            return redirect()->back()->withErrors(['error' => 'Nama ilmiah tersebut sudah ada.'])->withInput();
        }

        // Tentukan nama_keluarga yang akan digunakan
        $jenisMangrove->nama_keluarga = $validatedData['nama_keluarga_select'] ?? $validatedData['nama_keluarga_manual'];
        $jenisMangrove->nama_ilmiah = $validatedData['nama_ilmiah'];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $jenisMangrove->image = $imageName;
        }

        $jenisMangrove->save();

        return redirect()->route('admin.mangrove')->with('success', 'Jenis Mangrove berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $jenisMangrove = JenisMangrove::findOrFail($id);
        $jenisMangrove->delete();
        return response()->json(['success' => 'Jenis mangrove deleted successfully.']);
    }

    public function view($id)
    {
        $jenisMangrove = JenisMangrove::findOrFail($id);
        return view('admin.mangrove.view', compact('jenisMangrove'));
    }
}
