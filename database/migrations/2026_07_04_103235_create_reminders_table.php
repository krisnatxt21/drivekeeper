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
    Schema::create('reminders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete(); // milik kendaraan mana
        $table->string('title');                        // judul pengingat: Ganti Oli, Servis Berkala
        $table->date('reminder_date');                  // tanggal pengingat
        $table->unsignedInteger('odometer_threshold')->nullable(); // km trigger pengingat, boleh kosong
        $table->text('notes')->nullable();              // catatan, boleh kosong
        $table->boolean('is_done')->default(false);     // sudah selesai atau belum
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
