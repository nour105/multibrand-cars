<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
{
    Schema::table('offers', function (Blueprint $table) {
        if (!Schema::hasColumn('offers', 'banners')) {
            $table->json('banners')->nullable()->after('description');
        }

        if (!Schema::hasColumn('offers', 'currency')) {
            $table->enum('currency', ['USD', 'SAR'])->default('USD')->after('price');
        }
    });
}

public function down(): void
{
    Schema::table('offers', function (Blueprint $table) {
        if (Schema::hasColumn('offers', 'banners')) {
            $table->dropColumn('banners');
        }
        if (Schema::hasColumn('offers', 'currency')) {
            $table->dropColumn('currency');
        }
    });
}

};
