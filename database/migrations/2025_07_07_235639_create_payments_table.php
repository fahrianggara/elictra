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
            $table->string('name'); // Bank BCA, OVO, etc.
            $table->decimal('fee', 8, 2)->default(0.00); // Transaction fee, e.g., 5000.00
            $table->string('type'); // bank_transfer, e-wallet, etc.
            $table->string('label'); // No.Rekening, No.Akun, etc.
            $table->unsignedBigInteger('number'); // 1231231231321
            $table->string('logo')->nullable(); // URL to the logo image
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('payment_date');
            $table->unsignedInteger('amount');
            $table->string('proof_file')->nullable();
            $table->boolean('verified')->default(false);
            $table->foreignId('bill_id')->constrained('bills')->onDelete('cascade');
            $table->foreignId('method_id')->constrained('payment_methods')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('payments');
    }
};
