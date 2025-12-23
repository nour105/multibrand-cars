<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
{
    if (!Schema::hasColumn('cars', 'content')) {
        Schema::table('cars', function (Blueprint $table) {
            $table->longText('content')->nullable()->after('description');
        });
    }
}

public function down(): void
{
    if (Schema::hasColumn('cars', 'content')) {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('content');
        });
    }
}

};
