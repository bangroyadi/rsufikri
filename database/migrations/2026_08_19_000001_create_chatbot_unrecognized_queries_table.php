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
        Schema::create('chatbot_unrecognized_queries', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable()->index();
            $table->text('raw_query');
            $table->text('normalized_query')->nullable();
            $table->string('detected_intent')->nullable();
            $table->decimal('confidence_score', 5, 2)->default(0.00);
            $table->boolean('is_resolved')->default(false)->index();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_unrecognized_queries');
    }
};
