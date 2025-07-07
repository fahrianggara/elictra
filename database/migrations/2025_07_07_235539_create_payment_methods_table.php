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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // bank_transfer, e-wallet, etc.
            $table->string('label'); // e.g., "Bank Transfer", "E-Wallet"
            $table->string('icon')->nullable(); // Path to the icon file
            $table->boolean('is_active')->default(true); // Indicates if the payment method is active
            $table->text('description')->nullable(); // Additional information about the payment method
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
