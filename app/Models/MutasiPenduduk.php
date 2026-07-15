<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MutasiPenduduk extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class);
    }
}
