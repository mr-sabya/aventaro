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
        Schema::create('destination_faq', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained()->onDelete('cascade');

            // Foreign key for the DestinationFaq model
            // Laravel correctly infers the table name 'destination_faqs' and 'id' column
            $table->foreignId('destination_faq_id')->constrained('destination_faqs')->onDelete('cascade');

            // Set the primary key to be a combination of the two IDs
            $table->primary(['destination_id', 'destination_faq_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination_faq');
    }
};
