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
        Schema::create('featured_tour_sections', function (Blueprint $table) {
            $table->id();
            $table->string('subtitle')->default('Featured Places');
            $table->string('title')->default('Amazing Tour Places');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('featured_tour_sections');
    }
};
