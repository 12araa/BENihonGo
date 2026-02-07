<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stage;

class StageSeeder extends Seeder
{
    public function run(): void
    {
        $stages = [
            [
                'chapter_id' => 1,
                'name' => 'Angka Dasar (1-5)',
                'description' => 'Mempelajari bentuk kanji paling dasar untuk angka 1 sampai 5.',
                'stage_number' => 1,
                'level_req' => '1',
                'is_boss_level' => false,
                'monster_id' => 1,
            ],
            [
                'chapter_id' => 1,
                'name' => 'Angka Lanjutan (6-10)',
                'description' => 'Melanjutkan hafalan angka dari 6 sampai 10.',
                'stage_number' => 2,
                'level_req' => '2',
                'is_boss_level' => false,
                'monster_id' => 1,
            ],
            [
                'chapter_id' => 1,
                'name' => 'Puluhan & Ratusan',
                'description' => 'Menggabungkan angka menjadi puluhan dan ratusan.',
                'stage_number' => 3,
                'level_req' => '3',
                'is_boss_level' => false,
                'monster_id' => 2,
            ],
            [
                'chapter_id' => 1,
                'name' => 'Ujian Matematika Ninja',
                'description' => 'Kalahkan penjaga gerbang angka untuk lulus!',
                'stage_number' => 4,
                'level_req' => '5',
                'is_boss_level' => true,
                'monster_id' => 3,
            ],
            [
                'chapter_id' => 2,
                'name' => 'Elemen Tata Surya',
                'description' => 'Kanji untuk Matahari, Bulan, Api, dan Air.',
                'stage_number' => 1,
                'level_req' => '6',
                'is_boss_level' => false,
                'monster_id' => 2,
            ],
            [
                'chapter_id' => 2,
                'name' => 'Elemen Alam',
                'description' => 'Kanji Pohon, Emas, dan Tanah.',
                'stage_number' => 2,
                'level_req' => '7',
                'is_boss_level' => false,
                'monster_id' => 4,
            ],
            [
                'chapter_id' => 2,
                'name' => 'Geografi',
                'description' => 'Kanji bentang alam seperti Gunung dan Sungai.',
                'stage_number' => 3,
                'level_req' => '8',
                'is_boss_level' => false,
                'monster_id' => 4,
            ],
            [
                'chapter_id' => 2,
                'name' => 'Boss Pengendali Elemen',
                'description' => 'Buktikan penguasaan elemenmu di sini!',
                'stage_number' => 4,
                'level_req' => '10',
                'is_boss_level' => true,
                'monster_id' => 5,
            ],
            [
                'chapter_id' => 3,
                'name' => 'Orang & Tubuh',
                'description' => 'Kanji yang berkaitan dengan manusia.',
                'stage_number' => 1,
                'level_req' => '11',
                'is_boss_level' => false,
                'monster_id' => 4,
            ],
            [
                'chapter_id' => 3,
                'name' => 'Waktu & Jam',
                'description' => 'Mengenal konsep waktu dalam Kanji.',
                'stage_number' => 2,
                'level_req' => '12',
                'is_boss_level' => false,
                'monster_id' => 6,
            ],
            [
                'chapter_id' => 3,
                'name' => 'Survival Desa',
                'description' => 'Ujian terakhir sebelum merantau ke kota.',
                'stage_number' => 3,
                'level_req' => '15',
                'is_boss_level' => true,
                'monster_id' => 7,
            ],
        ];

        foreach ($stages as $stage) {
            Stage::create($stage);
        }
    }
}
