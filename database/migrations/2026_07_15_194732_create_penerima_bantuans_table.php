<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penerima_bantuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bantuan_sosial_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warga_id')->constrained()->cascadeOnDelete();
            $table->enum('status_penerimaan', ['Aktif', 'Ditangguhkan', 'Diberhentikan'])->default('Aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Unique constraint to prevent a warga from being registered twice in the same program
            $table->unique(['bantuan_sosial_id', 'warga_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerima_bantuans');
    }
};
