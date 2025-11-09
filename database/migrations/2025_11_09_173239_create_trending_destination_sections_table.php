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
        Schema::create('trending_destination_sections', function (Blueprint $table) {
            $table->id();
            $table->string('subtitle')->default('Trending Destinations');
            $table->string('title')->default('Trendy Travel Locations');
            $table->string('button_text')->default('Explore More');
            $table->string('button_url')->default('/destinations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trending_destination_sections');
    }
};
