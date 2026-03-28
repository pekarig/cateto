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
        Schema::create('contact_interactions', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // 'checkbox_checked' vagy 'accept_button_clicked'
            $table->string('ip_address', 45)->nullable(); // IPv4/IPv6
            $table->text('user_agent')->nullable();
            $table->string('session_id', 100)->nullable();
            $table->string('referrer')->nullable(); // Honnan érkezett
            $table->timestamps();

            // Index a gyakori lekérdezésekhez
            $table->index('action');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_interactions');
    }
};
