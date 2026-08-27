<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // e.g. {"id": "Perawat Pelaksana Rawat Inap", "en": "Inpatient Staff Nurse"}
            $table->string('slug')->unique();
            $table->string('department')->default('Keperawatan'); // Medis, Keperawatan, Penunjang Medis, Farmasi, Administrasi & IT, Umum
            $table->string('employment_type')->default('Full Time'); // Full Time, Kontrak, Part Time, Magang / Internship
            $table->string('education_level')->default('D3 / S1'); // D3, S1, Profesi Ners, Dokter Umum, S2
            $table->string('experience_years')->default('Fresh Graduate / 1 Tahun'); // Fresh Graduate, 1-2 Tahun, 3+ Tahun
            $table->string('location')->default('RSU Fikri Medika, Karawang');
            $table->string('quota')->nullable(); // e.g. "3 Orang"
            $table->json('short_description')->nullable();
            $table->json('description')->nullable();
            $table->json('requirements')->nullable(); // Array of bullet requirements
            $table->json('responsibilities')->nullable(); // Array of job responsibilities
            $table->json('benefits')->nullable(); // Array of benefits/facilities
            $table->date('deadline')->nullable(); // Batas akhir pendaftaran
            $table->string('status')->default('open'); // open, closed
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
