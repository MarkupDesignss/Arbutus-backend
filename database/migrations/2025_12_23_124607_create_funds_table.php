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
        Schema::create('funds', function (Blueprint $table) {
            $table->id();
            $table->string('fundatakey')->unique();     // 111622
            $table->string('symbol_code')->nullable();  // VPM450
            $table->string('fund_name');                // Fund full name

            // Master references
            $table->foreignId('firm_id')->constrained('firms')->onDelete('cascade'); 
            $table->foreignId('asset_class_id')->constrained('asset_classes')->onDelete('cascade'); 
            $table->foreignId('type_id')->constrained('types')->onDelete('cascade'); 
            $table->foreignId('strategy_id')->constrained('strategies')->onDelete('cascade'); 
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); 
            $table->foreignId('risk_rating_id')->constrained('risk_ratings')->onDelete('cascade'); 

            $table->decimal('fund_aum', 12, 2)->nullable();
            // External links
            $table->text('fund_library_link')->nullable();
            $table->text('external_link')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0 = InActive, 1 = Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funds');
    }
};