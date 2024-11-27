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
        Schema::create('ussd_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->string('phone_number');
            $table->text('current_path')->nullable();; // Tracks where the user is in the menu
            $table->json('menu_history')->nullable(); // Stores the history of menu paths
            $table->json('user_data')->nullable(); // Stores temporary user data
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ussd_sessions');
    }
};
