<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiktok_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('views_count')->default('10.5K');
            $table->string('tag')->nullable()->default('#RSUFikriMedika');
            $table->string('thumbnail')->nullable();
            $table->string('video_url')->nullable();
            $table->string('tiktok_url')->nullable()->default('https://www.tiktok.com/@rsu.fikrimedika');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiktok_posts');
    }
};
