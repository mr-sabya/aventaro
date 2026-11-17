<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('provider', 30)->unique();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_sandbox')->default(true);
            $table->text('store_id')->nullable();        // encrypted
            $table->text('store_password')->nullable();  // encrypted
            $table->string('currency', 10)->default('BDT');
            $table->decimal('rate', 12, 4)->default(1);  // how many `currency` units one price unit is worth
            $table->timestamps();
        });

        // Allow a third payment method (the enum could not take new values on every database).
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('payment_method', 30)->default('pay_later')->change();
            $table->string('transaction_id', 80)->nullable()->unique()->after('payment_status');
            $table->string('gateway_reference', 120)->nullable()->after('transaction_id');
            $table->timestamp('paid_at')->nullable()->after('gateway_reference');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropUnique(['transaction_id']);
            $table->dropColumn(['transaction_id', 'gateway_reference', 'paid_at']);
        });
        Schema::dropIfExists('payment_gateways');
    }
};
