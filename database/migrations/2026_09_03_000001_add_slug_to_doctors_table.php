<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Doctor;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('doctors', 'slug')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('name')->index();
            });
        }

        // Populate unique slugs for all existing doctors
        $doctors = Doctor::all();
        $usedSlugs = [];

        foreach ($doctors as $doctor) {
            $baseSlug = Str::slug($doctor->name);
            if (empty($baseSlug)) {
                $baseSlug = 'dokter-' . $doctor->id;
            }

            $slug = $baseSlug;
            $counter = 1;
            while (in_array($slug, $usedSlugs) || Doctor::where('slug', $slug)->where('id', '!=', $doctor->id)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }

            $usedSlugs[] = $slug;
            $doctor->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('doctors', 'slug')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
