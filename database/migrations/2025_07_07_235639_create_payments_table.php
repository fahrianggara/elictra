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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('payment_date');
            $table->unsignedInteger('amount');
            $table->string('proof_file')->nullable(); // Path to the proof of payment file
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
        Schema::dropIfExists('payments');
    }
};
