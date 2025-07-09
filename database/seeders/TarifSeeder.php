<?php

namespace Database\Seeders;

use App\Models\Tarif;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TarifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tarifs = [
            [
                'type' => 'R1',
                'power' => 450,
                'per_kwh' => 415.00,
                'penalty_per_day' => 1000.00,
                'description' => 'Segmentasi pelanggan rumah tangga dengan konsumsi listrik sangat rendah, biasanya digunakan oleh keluarga berpenghasilan rendah dengan kebutuhan listrik dasar seperti lampu, kipas angin, dan televisi.'
            ],
            [
                'type' => 'R1',
                'power' => 900,
                'per_kwh' => 605.00,
                'penalty_per_day' => 1500.00,
                'description' => 'Ditujukan untuk rumah tangga kecil dengan konsumsi listrik yang sedikit lebih tinggi, cocok untuk keluarga dengan peralatan elektronik dasar seperti kulkas dan rice cooker.'
            ],
            [
                'type' => 'R1',
                'power' => 1300,
                'per_kwh' => 1444.70,
                'penalty_per_day' => 2000.00,
                'description' => 'Diperuntukkan bagi rumah tangga menengah yang memiliki kebutuhan listrik sedang, mencakup penggunaan AC, mesin cuci, dan perangkat elektronik lainnya secara bersamaan.'
            ],
            [
                'type' => 'R2',
                'power' => 2200,
                'per_kwh' => 1444.70,
                'penalty_per_day' => 3000.00,
                'description' => 'Cocok untuk rumah tangga besar dengan banyak peralatan elektronik dan listrik berkapasitas tinggi, termasuk beberapa unit AC, pemanas air, dan perangkat rumah pintar.'
            ],
            [
                'type' => 'R3',
                'power' => 6600,
                'per_kwh' => 1444.70,
                'penalty_per_day' => 5000.00,
                'description' => 'Dirancang untuk rumah tangga mewah atau bangunan besar dengan kebutuhan listrik sangat tinggi, biasanya dilengkapi sistem pendingin sentral, lift pribadi, dan sistem keamanan otomatis.'
            ],
        ];

        foreach ($tarifs as $tarif) {
            Tarif::updateOrCreate(
                ['type' => $tarif['type'], 'power' => $tarif['power']],
                [
                    'per_kwh' => $tarif['per_kwh'],
                    'penalty_per_day' => $tarif['penalty_per_day'],
                    'description' => $tarif['description'],
                ]
            );
        }
    }
}
