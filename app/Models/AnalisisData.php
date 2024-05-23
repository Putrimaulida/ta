<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalisisData extends Model
{
    use HasFactory;

    protected $fillable = [
        'pantai_id',
    ];

    // Relasi dengan model Pantai
    public function pantai()
    {
        return $this->belongsTo(Pantais::class);
    }
}
