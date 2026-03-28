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
        Schema::create('ai_tool_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->string('icon_path')->nullable(); // SVG/PNG icon
            $table->string('name'); // AI tool neve (pl: OpenAI)
            $table->text('description'); // Rich text leírás
            $table->string('button_text')->default('Megnyitás'); // Gomb szöveg
            $table->string('button_url'); // Külső vagy belső URL
            $table->boolean('button_target_blank')->default(false); // _blank target
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_tool_items');
    }
};
