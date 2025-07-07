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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('avatar')->default('avatar.png');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('role_id')->nullable()->constrained('roles')->nullOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('tarifs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('power'); // Daya dalam VA (Volt-Ampere)
            $table->decimal('per_kwh', 10, 2); // Harga per kWh
            $table->decimal('penalty_per_day', 10, 2)->default(0); // Denda per hari keterlambatan
            $table->text('description')->nullable(); // Deskripsi tarif
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('meter_number')->unique(); // Nomor meter kWh fisik
            $table->text('address');
            $table->unsignedInteger('initial_meter'); // Catatan awal meter kWh
            $table->boolean('is_blocked')->default(false);
            $table->text('block_reason')->nullable(); // Alasan pemblokiran
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tarif_id')->nullable()->constrained('tarifs')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('users');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
