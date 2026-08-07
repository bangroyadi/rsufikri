<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospital_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->text('address');
            $table->string('phone');
            $table->string('whatsapp');
            $table->string('email');
            $table->string('emergency_phone');
            $table->text('maps_embed')->nullable();
            $table->string('operating_hours');
            $table->json('social_links')->nullable();
            $table->json('about');
            $table->json('vision');
            $table->json('mission');
            $table->json('values')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospital_profiles');
    }
};
