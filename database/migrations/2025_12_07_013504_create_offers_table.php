<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
      Schema::create('offers', function (Blueprint $table) {
    $table->id();
    $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
    $table->string('title');
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2)->nullable();
    $table->string('currency', 3)->default('USD'); // USD or SAR
    $table->json('banners')->nullable();
    $table->date('start_date');
    $table->date('end_date');
    $table->timestamps();
});


        // Pivot table for multiple cars
       Schema::create('offer_car', function (Blueprint $table) {
    $table->id();
    $table->foreignId('offer_id')->constrained()->cascadeOnDelete();
    $table->foreignId('car_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('offer_car');
        Schema::dropIfExists('offers');
    }
};
