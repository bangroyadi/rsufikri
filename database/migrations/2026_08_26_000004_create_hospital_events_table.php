<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospital_events', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Seminar & Webinar'); // Seminar & Webinar, Bakti Sosial & Donor Darah, Workshop Medis, Senam & Edukasi Sehat, Umum
            $table->date('event_date');
            $table->string('start_time')->nullable(); // e.g. "08:30 WIB"
            $table->string('end_time')->nullable();   // e.g. "12:00 WIB"
            $table->string('location')->default('Auditorium Lt. 3 RSU Fikri Medika');
            $table->json('speakers')->nullable(); // Array of speaker objects [{"name": "dr. ...", "role": "Spesialis ..."}]
            $table->string('quota')->nullable(); // e.g. "100 Peserta"
            $table->string('price_type')->default('Gratis / Free'); // Gratis / Free, Berbayar
            $table->string('price')->nullable();
            $table->json('benefits')->nullable(); // Array of benefits ["Sertifikat SKP", "Snack", "Goodie Bag"]
            $table->string('image')->nullable(); // Flyer poster image
            $table->json('short_description')->nullable();
            $table->json('description')->nullable();
            $table->string('registration_link')->nullable();
            $table->string('whatsapp_contact')->nullable();
            $table->string('status')->default('upcoming'); // upcoming, ongoing, completed
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospital_events');
    }
};
