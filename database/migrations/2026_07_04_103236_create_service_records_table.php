<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->date('service_date');
            $table->string('workshop_name');
            $table->string('service_type');
            $table->unsignedInteger('odometer');
            $table->decimal('cost', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->string('receipt_photo')->nullable();
            $table->timestamps();

            $table->foreign('vehicle_id')
                  ->references('id')
                  ->on('vehicles')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_records');
    }
};
