<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable(); // General info
            $table->longText('content')->nullable(); // Detailed content
            $table->json('specifications')->nullable();
            $table->json('interior_images')->nullable();
            $table->json('exterior_images')->nullable();
            $table->string('price')->nullable(); // Price of car
$table->json('available_trims')->nullable(); // Available trims/colors
$table->json('colors')->nullable(); // Available exterior colors
$table->string('video_url')->nullable(); // Optional video link
$table->json('features')->nullable(); // Extra features, e.g., sunroof, AC

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
