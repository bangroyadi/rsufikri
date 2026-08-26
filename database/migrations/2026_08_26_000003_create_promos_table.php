<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Umum'); // Ibu & Anak, Medical Check Up, Poliklinik & Spesialis, Penunjang Medis, Gigi & Mulut, Umum
            $table->string('badge')->nullable(); // e.g. "HOT PROMO", "HEMAT 35%", "POPULER", "TERBATAS"
            $table->string('original_price')->nullable(); // e.g. "Rp 1.500.000"
            $table->string('promo_price')->nullable(); // e.g. "Rp 999.000"
            $table->integer('discount_percentage')->nullable(); // e.g. 35
            $table->string('image')->nullable(); // Flyer / Banner image
            $table->json('short_description')->nullable();
            $table->json('description')->nullable();
            $table->json('features')->nullable(); // Array of included items/benefits
            $table->json('terms_conditions')->nullable(); // Syarat & Ketentuan
            $table->date('valid_until')->nullable(); // Expiration date
            $table->string('whatsapp_number')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
