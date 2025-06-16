<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
    public function penulis()
    {
        return $this->belongsToMany(Penulis::class, 'tim_penulis', 'id_buku', 'id_penulis');
    }
    public function salinanBuku()
    {
        return $this->hasMany(SalinanBuku::class, 'id_buku');
    }

    public function salinanTersedia()
    {
        return $this->hasMany(SalinanBuku::class, 'id_buku')->where('status', 'tersedia');
    }
}
