<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisMangrove;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'), // You can use the bcrypt() helper to hash passwords
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Stakeholder',
                'email' => 'stakeholder@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'stakeholder',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $jenisMangroveData = [
            [
                'nama_keluarga' => 'Acanthaceae',
                'nama_ilmiah' => 'Acanthus ebracteatus',
            ],
            [
                'nama_keluarga' => 'Acanthaceae',
                'nama_ilmiah' => 'Acanthus ilicifolius',
            ],
            [
                'nama_keluarga' => 'Pteridaceae',
                'nama_ilmiah' => 'Acanthus volubilis',
            ],
            [
                'nama_keluarga' => 'Pteridaceae',
                'nama_ilmiah' => 'Acrostichum aureum',
            ],
            [
                'nama_keluarga' => 'Pteridaceae',
                'nama_ilmiah' => 'Acrostichum speciosum',
            ],
            // Tambahkan data lain sesuai kebutuhan
        ];

        // Loop through the data and create jenis mangrove records
        foreach ($jenisMangroveData as $jenisMangrove) {
            JenisMangrove::create($jenisMangrove);
        }
    }
}
