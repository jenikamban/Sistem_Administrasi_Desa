<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApbdRealisasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori', 'nama_item', 'anggaran', 'realisasi', 'tahun'
    ];
}
