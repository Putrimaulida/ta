<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pantais extends Model
{
    use HasFactory;

    protected $table = 'pantais';
    protected $fillable = [
        'jenis_mangrove_id',
        'nama_pantai',
        'lokasi_pantai',
        'longitude',
        'latitude',
        'komen',
        'image',
        'video',
        'status',
    ];

    public function citraSatelit()
    {
        return $this->hasMany(CitraSatelit::class);
    }

    public function jenisMangroves()
    {
        return $this->belongsToMany(JenisMangrove::class, 'pantai_jenis_mangrove', 'pantai_id', 'jenis_mangrove_id');
    }
}
