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
       Schema::create('cta_clicks', function (Blueprint $table) {
    $table->id();
    $table->string('cta'); // request_form | callback
    $table->unsignedBigInteger('car_id')->nullable();
    $table->string('car_name')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cta_clicks');
    }
};
