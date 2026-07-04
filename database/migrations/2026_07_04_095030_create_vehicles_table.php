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
    Schema::create('vehicles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // milik user mana
        $table->string('brand');                            // merk: Toyota, Honda
        $table->string('model');                            // model: Avanza, Beat
        $table->year('year');                               // tahun: 2020
        $table->string('plate_number')->unique();           // plat nomor
        $table->string('color')->nullable();                // warna
        $table->string('engine_number')->nullable();        // nomor mesin
        $table->string('chassis_number')->nullable();       // nomor rangka
        $table->unsignedInteger('odometer')->default(0);    // odometer (km)
        $table->string('photo')->nullable();                // foto kendaraan
        $table->timestamps();
    });
}


public function down(): void
{
    Schema::dropIfExists('vehicles');
}
};
