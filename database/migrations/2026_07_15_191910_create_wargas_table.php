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
        Schema::create('wargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kartu_keluarga_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nik', 16)->unique();
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('agama');
            $table->enum('status_perkawinan', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']);
            $table->string('pekerjaan');
            $table->text('alamat');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('dusun');
            $table->enum('status_hubungan_keluarga', ['Kepala Keluarga', 'Suami', 'Istri', 'Anak', 'Mertua', 'Orang Tua', 'Lainnya']);
            $table->enum('status_keaktifan', ['Aktif', 'Meninggal', 'Pindah'])->default('Aktif');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
        
        Schema::table('kartu_keluargas', function (Blueprint $table) {
            $table->foreign('kepala_keluarga_id')->references('id')->on('wargas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kartu_keluargas', function (Blueprint $table) {
            $table->dropForeign(['kepala_keluarga_id']);
        });
        Schema::dropIfExists('wargas');
    }
};
