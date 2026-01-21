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
        Schema::create('fund_performance_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fund_id')
            ->constrained('funds')
            ->cascadeOnDelete();
            $table->date('as_of_month');
            $table->decimal('one_month', 6, 2)->nullable();
            $table->decimal('ytd', 6, 2)->nullable();
            $table->decimal('one_year', 6, 2)->nullable();
            $table->decimal('three_year', 6, 2)->nullable();
            $table->decimal('since_inception', 6, 2)->nullable();
            $table->decimal('three_year_std_dev', 6, 2)->nullable();
            $table->decimal('distribution_yield', 6, 2)->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            $table->unique(['fund_id', 'as_of_month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_performance_snapshots');
    }
};
