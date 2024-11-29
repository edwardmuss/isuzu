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
        Schema::create('loyalties', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('email_subject')->nullable();
            $table->text('sms_message')->nullable();
            $table->text('email_body')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalties');
    }
};
