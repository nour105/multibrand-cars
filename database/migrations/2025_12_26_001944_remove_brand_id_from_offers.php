<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('offers', function (Blueprint $table) {
            if (Schema::hasColumn('offers', 'brand_id')) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $doctrineTable = $sm->listTableDetails('offers');
                
                if ($doctrineTable->hasForeignKey('offers_brand_id_foreign')) {
                    $table->dropForeign('offers_brand_id_foreign');
                }

                $table->dropColumn('brand_id');
            }
        });
    }

    public function down(): void {
        Schema::table('offers', function (Blueprint $table) {
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('cascade');
        });
    }
};
