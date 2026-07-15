<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $guarded = ['id'];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }

    public function penanggap()
    {
        return $this->belongsTo(User::class, 'tanggapan_oleh');
    }
}
