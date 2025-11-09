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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            // --- Relational & Location ---
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->string('address')->nullable()->comment('Specific meeting point or street address');

            // --- Core Details ---
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');

            // --- Pricing ---
            $table->decimal('price', 8, 2)->comment('Current price for the tour');
            $table->decimal('old_price', 8, 2)->nullable()->comment('A discounted/previous price');

            // --- Card/Summary Info ---
            $table->string('duration')->comment('Example: 3 Days / 2 Night');
            $table->string('countries_covered')->nullable()->comment('Example: 3 Countries');
            $table->string('thumbnail_image')->comment('Image for listings and cards');

            // --- Details Page Content ---
            $table->string('details_image')->comment('Main image for the tour details page');
            $table->json('features')->nullable()->comment('For the "Experience the Difference" list');
            $table->text('map_embed_url')->nullable();

            // --- Ratings & Reviews ---
            $table->decimal('rating', 2, 1)->default(0);
            $table->integer('review_count')->default(0);

            // --- Control Flags ---
            $table->boolean('is_featured')->default(false)->index()->comment('Show on homepage "Featured Places"');
            $table->boolean('is_hot_deal')->default(false)->index()->comment('Show in "Discover Weekly" slider');
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
