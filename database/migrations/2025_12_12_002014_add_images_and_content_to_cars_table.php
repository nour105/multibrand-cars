<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            if (!Schema::hasColumn('cars', 'content')) {
                $table->longText('content')->nullable()->after('description');
            }
            if (!Schema::hasColumn('cars', 'interior_images')) {
                $table->json('interior_images')->nullable()->after('specifications');
            }
            if (!Schema::hasColumn('cars', 'exterior_images')) {
                $table->json('exterior_images')->nullable()->after('interior_images');
            }
            if (!Schema::hasColumn('cars', 'price')) {
                $table->string('price')->nullable()->after('exterior_images');
            }
            if (!Schema::hasColumn('cars', 'available_trims')) {
                $table->json('available_trims')->nullable()->after('price');
            }
            if (!Schema::hasColumn('cars', 'colors')) {
                $table->json('colors')->nullable()->after('available_trims');
            }
            if (!Schema::hasColumn('cars', 'features')) {
                $table->json('features')->nullable()->after('colors');
            }
            if (!Schema::hasColumn('cars', 'video_url')) {
                $table->string('video_url')->nullable()->after('features');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn([
                'content',
                'interior_images',
                'exterior_images',
                'price',
                'available_trims',
                'colors',
                'features',
                'video_url',
            ]);
        });
    }
};
