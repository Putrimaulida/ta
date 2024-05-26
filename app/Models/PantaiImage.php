<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PantaiImage extends Model
{
    use HasFactory;
    protected $table = 'pantai_images';
    protected $fillable = ['pantai_id', 'path'];

    public function pantai()
    {
        return $this->belongsTo(Pantais::class);
    }
}