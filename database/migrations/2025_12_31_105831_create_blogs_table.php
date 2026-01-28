<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('short_description', 500)->nullable();
            $table->longText('long_description');
            $table->string('image')->nullable();
            $table->string('author_name')->nullable();
            $table->date('post_date')->nullable();
            // ✅ NEW FIELDS
            $table->enum('type', ['news', 'education'])->default('news');
            $table->string('video_url')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0 = InActive, 1 = Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
