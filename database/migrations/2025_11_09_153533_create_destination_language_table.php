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
        Schema::create('destination_language', function (Blueprint $table) {
            $table->foreignId('destination_id')->constrained()->onDelete('cascade');
            $table->foreignId('language_id')->constrained()->onDelete('cascade');

            // Set the primary key to be a combination of the two IDs
            $table->primary(['destination_id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination_language');
    }
};
