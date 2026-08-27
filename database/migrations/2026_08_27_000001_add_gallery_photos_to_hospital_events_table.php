<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hospital_events', function (Blueprint $table) {
            // Array of photo paths untuk dokumentasi pasca event
            $table->json('gallery_photos')->nullable()->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('hospital_events', function (Blueprint $table) {
            $table->dropColumn('gallery_photos');
        });
    }
};
