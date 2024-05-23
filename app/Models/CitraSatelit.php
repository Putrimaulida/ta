<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitraSatelit extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'luasan',
        'pantai_id',
    ];

    public function pantai()
    {
        return $this->belongsTo(Pantais::class, 'pantai_id');
    }
}
