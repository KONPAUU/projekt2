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
        Schema::table('subjects', function (Blueprint $table) {
            if (!Schema::hasColumn('subjects', 'code')) {
                $table->string('code', 10)->nullable()->after('name');
            }
            if (!Schema::hasColumn('subjects', 'category')) {
                $table->string('category')->nullable()->after('description');
            }
            if (!Schema::hasColumn('subjects', 'icon')) {
                $table->string('icon', 50)->nullable()->after('category');
            }
            if (!Schema::hasColumn('subjects', 'color')) {
                $table->string('color', 20)->nullable()->after('icon');
            }
            if (!Schema::hasColumn('subjects', 'hours_per_week')) {
                $table->integer('hours_per_week')->nullable()->after('color');
            }
            if (!Schema::hasColumn('subjects', 'is_mandatory')) {
                $table->boolean('is_mandatory')->default(true)->after('hours_per_week');
            }
            if (!Schema::hasColumn('subjects', 'has_final_exam')) {
                $table->boolean('has_final_exam')->default(false)->after('is_mandatory');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn(['code', 'category', 'icon', 'color', 'hours_per_week', 'is_mandatory', 'has_final_exam']);
        });
    }
};
