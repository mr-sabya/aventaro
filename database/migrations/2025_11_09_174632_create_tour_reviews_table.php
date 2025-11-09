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
        Schema::create('tour_reviews', function (Blueprint $table) {
            $table->id();
            // --- Relationships ---
            $table->foreignId('tour_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // --- Guest User Information (nullable) ---
            $table->string('name')->nullable()->comment('Required only if user_id is null');
             $table->string('email')->nullable()->comment('Required only if user_id is null');
            $table->string('phone')->nullable()->comment('Optional for guests');
            $table->string('location')->nullable()->comment('Example: from New York, USA');
            $table->string('image')->nullable()->comment('Path to guest avatar image');

            // --- Review Details ---
            $table->tinyInteger('rating')->unsigned()->comment('Rating from 1 to 5');
            $table->text('comment');
            $table->boolean('is_approved')->default(false)->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_reviews');
    }
};
