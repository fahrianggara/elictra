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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->unique(); // Unique invoice number
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('period', 7); // format YYYY-MM
            $table->unsignedInteger('meter_start');
            $table->unsignedInteger('meter_end');
            $table->enum('status', ['unpaid', 'paid', 'overdue', 'blocked', 'waiting'])->default('unpaid');
            $table->date('due_date'); // tanggal jatuh tempo pembayaran
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
