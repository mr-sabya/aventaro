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
        Schema::create('discover_sections', function (Blueprint $table) {
            $table->id();
            $table->string('subtitle')->default('Discover Weekly Travelling');
            $table->string('title')->default('Hot deals on select expedition departures');
            $table->text('description');
            $table->string('button_text')->default('Explore More');
            $table->string('button_url')->default('/tours');
            $table->string('background_image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discover_sections');
    }
};
