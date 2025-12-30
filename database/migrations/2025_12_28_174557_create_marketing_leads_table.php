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
    {{
    Schema::create('marketing_leads', function (Blueprint $table) {
        $table->id();

        // User
        $table->string('name');
        $table->string('phone');
        $table->string('email')->nullable();

        // Offer specific
        $table->decimal('salary', 12, 2)->nullable();
        $table->string('bank')->nullable();

        // Source
        $table->enum('source_type', ['car', 'offer']);
        $table->unsignedBigInteger('source_id')->nullable();

        // Meta
        $table->string('car_name')->nullable();
        $table->string('offer_title')->nullable();
        $table->string('price')->nullable();
        $table->string('currency')->nullable();

        // UTM
        $table->string('utm_source')->nullable();
        $table->string('utm_medium')->nullable();
        $table->string('utm_campaign')->nullable();
        $table->string('utm_term')->nullable();
        $table->string('utm_content')->nullable();

        $table->timestamps();
    });
}

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_leads');
    }
};
