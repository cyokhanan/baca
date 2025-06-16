<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    protected $table = 'peminjams';
    protected $fillable = ['nama', 'email', 'telepon', 'alamat', 'deposit'];
}
