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
        Schema::create('surat_permohonans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable();
            $table->enum('jenis_surat', ['SKU', 'SKTM', 'SKD', 'SK_Kematian', 'SK_Pindah', 'Surat_Pengantar']);
            $table->foreignId('warga_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pengaju_id')->constrained('users');
            $table->text('keperluan');
            $table->text('keterangan_tambahan')->nullable();
            $table->enum('status', ['Draft', 'Ditinjau_Staf', 'Menunggu_Tanda_Tangan', 'Disetujui', 'Ditolak'])->default('Draft');
            $table->text('catatan_penolakan')->nullable();
            $table->timestamp('tanggal_pengajuan')->useCurrent();
            $table->timestamp('tanggal_persetujuan')->nullable();
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users');
            $table->string('file_surat')->nullable();
            $table->string('qr_code_token', 64)->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_permohonans');
    }
};
