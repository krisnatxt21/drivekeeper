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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete(); // milik kendaraan mana
            $table->date('expense_date');                    // tanggal pengeluaran
            $table->string('category');                     // kategori: servis, ban, oli, modifikasi, lainnya
            $table->string('description');                  // deskripsi singkat
            $table->decimal('amount', 12, 2);               // jumlah uang
            $table->text('notes')->nullable();              // catatan tambahan, boleh kosong
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
