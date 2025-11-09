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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->foreignId('currency_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();

            // --- CONTENT & MEDIA ---
            $table->string('image')->comment('Thumbnail or card image');
            $table->text('description')->nullable();

            // --- DETAILED INFORMATION ---
            $table->string('visa_requirements')->nullable();
            $table->string('area')->nullable()->comment('Example: 88.000 km2');
            $table->text('map_embed_url')->nullable();
            $table->json('features')->nullable()->comment('Stores the list from "Experience the Difference"');

            // --- CONTROL FLAGS ---
            $table->boolean('is_trending')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
