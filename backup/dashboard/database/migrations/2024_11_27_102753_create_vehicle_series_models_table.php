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
        Schema::create('vehicle_series_models', function (Blueprint $table) {
            $table->id();
            $table->string('series');
            $table->string('previous_name')->nullable(); // Backend-only name
            $table->string('new_model_name_backend')->nullable(); // Backend-only model name
            $table->string('new_model_name_customer')->nullable(); // Customer-facing model name
            $table->text('description')->nullable(); // Description for quotes
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('photo')->nullable(); // Path to uploaded photos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_series_models');
    }
};
