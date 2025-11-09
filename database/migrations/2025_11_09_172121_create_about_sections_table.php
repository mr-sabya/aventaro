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
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            // Main Content
            $table->string('subtitle')->default('About Travil Agency');
            $table->string('title')->default('Our Journey Memorable Adventures Worldwide');
            $table->text('description');
            $table->text('quote')->nullable();

            // Images
            $table->string('main_image'); // For '03.jpg'

            // Counter Box
            $table->integer('experience_years')->default(29);

            // Button
            $table->string('button_text')->default('More About Travil');
            $table->string('button_url')->default('/about-us');

            // List Items
            $table->json('features')->nullable()->comment('Stores the icon list items');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};
