<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipDokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'jenis_dokumen',
        'file_path',
        'diarsipkan_oleh',
        'tanggal_arsip',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_arsip' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'diarsipkan_oleh');
    }
}
