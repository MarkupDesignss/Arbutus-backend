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
        Schema::create('access_rules', function (Blueprint $table) {
            $table->id();
            $table->string('module');
            $table->enum('rule_type', ['column', 'filter', 'feature']);
            $table->string('rule_key')->nullable();
            $table->string('label')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0 = InActive, 1 = Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_rules');
    }
};
