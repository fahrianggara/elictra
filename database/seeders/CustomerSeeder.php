<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Customer',
            'email' => 'customer@elictra.com',
            'password' => bcrypt('password'),
            'role_id' => 3, // Assuming role_id 3 is for customer
        ])->customer()->create([
            'meter_number' => '1234567891234',
            'address' => 'Jl. Contoh Alamat No. 123',
            'initial_meter' => 100,
            'is_blocked' => false,
            'block_reason' => null,
            'tarif_id' => 3, // Assuming tarif_id 4 exists
        ]);
    }
}
