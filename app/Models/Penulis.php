<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penulis extends Model
{
    use HasFactory;
    public function bukus()
    {
        return $this->belongsToMany(Buku::class, 'tim_penulis', 'idpenulis', 'idbuku');
    }
}
