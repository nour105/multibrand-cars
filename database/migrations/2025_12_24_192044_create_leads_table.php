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
        Schema::create('leads', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('phone');

    $table->string('salary_range')->nullable();
    $table->string('bank')->nullable();
    $table->string('loan_type')->nullable();
    $table->string('visa_limit')->nullable();
    $table->string('purchase_timeline')->nullable();

    $table->boolean('marketing_consent')->default(false);
    $table->boolean('privacy_accepted');

    $table->decimal('emi_budget', 10, 2)->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
