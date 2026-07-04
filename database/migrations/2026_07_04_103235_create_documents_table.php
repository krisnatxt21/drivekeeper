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
    Schema::create('documents', function (Blueprint $table) {
        $table->id();
        $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete(); // milik kendaraan mana
        $table->string('title');                        // judul dokumen: STNK, KIR, Asuransi
        $table->string('file_path');                    // path file yang diupload
        $table->date('expired_at')->nullable();         // tanggal kadaluarsa, boleh kosong
        $table->text('notes')->nullable();              // catatan, boleh kosong
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
