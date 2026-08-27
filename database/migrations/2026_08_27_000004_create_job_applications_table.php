<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_id')->constrained('careers')->onDelete('cascade');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('last_education')->nullable(); // D3, S1, Ners, dll
            $table->string('experience_years')->nullable();
            $table->string('str_number')->nullable(); // Nomor STR untuk nakes (Surat Tanda Registrasi) jika ada
            $table->string('cv_file'); // Path to uploaded CV file (PDF/DOC)
            $table->string('portfolio_url')->nullable();
            $table->text('cover_letter')->nullable();
            $table->string('status')->default('pending'); // pending, reviewed, interview, accepted, rejected
            $table->text('hrd_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
