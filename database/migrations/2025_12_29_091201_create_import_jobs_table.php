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
        Schema::create('import_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins');
            $table->string('original_filename');
            $table->string('stored_filename');
            $table->enum('status', [
                'uploaded',
                'validating',
                'failed',
                'validated',
                'processing',
                'completed'
            ])->default('uploaded');
            $table->date('as_of_month');
            $table->integer('total_rows')->default(0);
            $table->integer('valid_rows')->default(0);
            $table->integer('invalid_rows')->default(0);
            $table->json('summary')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_jobs');
    }
};