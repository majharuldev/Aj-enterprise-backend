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
            $table->BigInteger('user_id'); // vehicle belongs to a user
            $table->string('date');
            $table->string('driver_name');
            $table->string('vehicle_size');
            $table->string('vehicle_category');
            $table->string('reg_zone');
            $table->string('reg_serial');
            $table->string('reg_no');
            $table->string('reg_date');
            $table->string('status');
            $table->string('tax_date');
            $table->string('route_per_date');
            $table->string('fitness_date');
            $table->string('fuel_capcity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
