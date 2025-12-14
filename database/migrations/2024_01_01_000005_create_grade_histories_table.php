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
        Schema::create('grade_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grade_id');
            $table->decimal('old_grade', 2, 1);
            $table->decimal('new_grade', 2, 1);
            $table->unsignedBigInteger('changed_by'); // kto zmienił
            $table->text('reason')->nullable(); // powód zmiany
            $table->timestamp('created_at');

            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_histories');
    }
};