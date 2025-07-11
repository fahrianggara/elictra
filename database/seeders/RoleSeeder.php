<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Memiliki akses penuh ke seluruh fitur sistem, termasuk pengaturan, manajemen pengguna, dan kontrol data utama.'
            ],
            [
                'name' => 'petugas',
                'description' => 'Memiliki akses untuk mengelola data pelanggan, input meteran, dan verifikasi transaksi, tetapi tidak dapat mengakses pengaturan sistem dan manajemen pengguna.'
            ],
            [
                'name' => 'pelanggan',
                'description' => 'Pengguna akhir yang dapat melihat informasi tagihan, melakukan pembayaran, dan memantau riwayat transaksi mereka.'
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description']]
            );
        }
    }
}
