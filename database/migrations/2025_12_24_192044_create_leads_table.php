<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            // Basic
            $table->string('name');
            $table->string('phone');
            $table->string('email');

            // Financial (optional)
            $table->string('salary_range')->nullable();
            $table->boolean('has_loans')->default(false);
            $table->string('loan_type')->nullable();
            $table->string('visa_limit')->nullable();
            $table->string('bank')->nullable();

            // EMI
            $table->integer('emi_budget')->default(0);
            $table->boolean('emi_calculated')->default(false);

            // Selection
            $table->foreignId('car_id')->nullable()->constrained()->nullOnDelete();
            $table->string('purchase_timeline')->nullable();

            // Consents
            $table->boolean('marketing_consent')->default(false);
            $table->boolean('privacy_accepted');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
