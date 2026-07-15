<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KartuKeluarga extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function anggota(): HasMany
    {
        return $this->hasMany(Warga::class);
    }

    public function kepalaKeluarga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'kepala_keluarga_id');
    }
}
