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
        Schema::create('web_service_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->string('tagline'); // "Stack", "Backend", "Frontend"
            $table->string('icon_path')->nullable(); // SVG/PNG icon elérési út
            $table->string('heading'); // "Laravel", "Vanilla JS"
            $table->text('description'); // Rich text leírás
            $table->json('features')->nullable(); // Lista elemek ["Item 1", "Item 2"]
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_service_items');
    }
};
