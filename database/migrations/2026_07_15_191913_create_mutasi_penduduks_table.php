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
        Schema::create('mutasi_penduduks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained()->cascadeOnDelete();
            $table->enum('jenis_mutasi', ['Lahir', 'Meninggal', 'Masuk', 'Keluar']);
            $table->date('tanggal_mutasi');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_penduduks');
    }
};
