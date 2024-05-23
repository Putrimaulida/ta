<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisMangrove extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_keluarga',
        'nama_ilmiah',
    ];

    public function pantais()
    {
        return $this->belongsToMany(Pantais::class);
    }
}
