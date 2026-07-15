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
        Schema::create('inventaris_desas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_item');
            $table->string('kategori');
            $table->integer('jumlah');
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat']);
            $table->string('lokasi');
            $table->foreignId('penanggung_jawab_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('tanggal_pencatatan')->useCurrent();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris_desas');
    }
};
