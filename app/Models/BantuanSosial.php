<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BantuanSosial extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function penerimaBantuan(): HasMany
    {
        return $this->hasMany(PenerimaBantuan::class);
    }

    public function warga(): BelongsToMany
    {
        return $this->belongsToMany(Warga::class, 'penerima_bantuans')->withPivot('status_penerimaan', 'keterangan')->withTimestamps();
    }
}
