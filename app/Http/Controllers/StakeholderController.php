<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\User;

class StakeholderController extends Controller
{
    public function json()
    {
        $users = User::select(['id', 'name', 'email'])
             ->where('role', 'stakeholder')
             ->get();
        $index = 1;
        return DataTables::of($users)
            ->addColumn('DT_RowIndex', function ($data) use (&$index) {
                return $index++; // Menambahkan nomor urutan baris
            })
            ->addColumn('action', function ($row) {
                $editUrl = url('/dashboard_admin/stakeholder_management/edit/' . $row->id);
                $deleteUrl = url('/dashboard_admin/stakeholder_management/destroy/' . $row->id);
                return '<button type="button" class="btn btn-primary" onclick="window.location.href=\'' . $editUrl . '\'"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-danger delete-users" data-url="' . $deleteUrl . '"><i class="fas fa-trash-alt"></i></button>';
            })
            ->toJson();
    }
    public function index(){
        return view('admin.stakeholder.index');
    }
    public function create(){
        return view('admin.stakeholder.create');
    }
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Tambahkan user dengan role stakeholder
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Gunakan bcrypt untuk mengenkripsi password
            'role' => 'stakeholder', // Set role menjadi 'stakeholder'
        ]);

        // Berikan respons yang sesuai
        return redirect('/dashboard_admin/stakeholder_management')->with('success', 'User created successfully.');
    }

    public function edit(string $id)
    {
        $users = User::find($id);
        return view('admin.stakeholder.edit', compact('users'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8', // Password bersifat opsional untuk diubah
        ]);

        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Perbarui informasi user
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->has('password')) {
            $user->password = bcrypt($request->password); // Perbarui password jika disediakan
        }
        $user->save();

        // Berikan respons yang sesuai
        return redirect()->route('admin.stakeholder')->with('success', 'User updated successfully.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.stakeholder')->with('success', 'User deleted successfully.');
        //return response()->json(['success' => 'Stakeholder deleted successfully.']);
    }

}
