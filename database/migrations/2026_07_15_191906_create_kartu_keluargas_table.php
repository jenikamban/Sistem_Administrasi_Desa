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
        Schema::create('kartu_keluargas', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk', 16)->unique();
            $table->unsignedBigInteger('kepala_keluarga_id')->nullable(); // Foreign key to wargas will be implicit or added later
            $table->text('alamat');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('dusun');
            $table->string('kode_pos', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartu_keluargas');
    }
};
