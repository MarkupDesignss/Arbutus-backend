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
        Schema::create('import_job_rows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('import_job_id')->constrained('import_jobs')->cascadeOnDelete();
            $table->string('fundatakey')->nullable();
            $table->date('month_end')->nullable();
            $table->decimal('monthly_return', 8, 6)->nullable();
            $table->decimal('distribution_yield', 6, 2)->nullable();
            $table->boolean('is_valid')->default(false);
            $table->json('errors')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_job_rows');
    }
};
