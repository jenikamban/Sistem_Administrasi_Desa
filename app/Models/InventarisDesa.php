<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisDesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_item',
        'kategori',
        'jumlah',
        'kondisi',
        'lokasi',
        'penanggung_jawab_id',
        'tanggal_pencatatan',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_pencatatan' => 'datetime',
    ];

    public function penanggungJawab()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab_id');
    }
}
