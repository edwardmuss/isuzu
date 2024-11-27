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
        Schema::create('menu_options', function (Blueprint $table) {
            $table->id();
            $table->string('option_name');      // e.g., 'Vehicle Sales'
            $table->string('option_code');      // e.g., '1'
            $table->unsignedBigInteger('parent_id')->nullable(); // For submenus
            $table->string('action')->nullable(); // Action type like 'quote', 'price', etc.
            $table->integer('position')->default(0); // menu position
            $table->string('menu_message')->nullable(); // column for menu messages
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_options');
    }
};
