<?php

namespace Database\Seeders;

use App\Models\Stage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = [
            ['name' => 'Grade 1', 'level_req' => 1, 'desc' => 'Kanji Dasar Angka & Hari'],
            ['name' => 'Grade 2', 'level_req' => 3, 'desc' => 'Kanji Alam & Manusia'],
            ['name' => 'Grade 3', 'level_req' => 5, 'desc' => 'Kanji Sekolah & Waktu'],
            ['name' => 'Grade 4', 'level_req' => 10, 'desc' => 'Kanji Kata Kerja Dasar'],
            ['name' => 'Grade 5', 'level_req' => 15, 'desc' => 'Kanji Kata Sifat'],
            ['name' => 'Grade 6', 'level_req' => 20, 'desc' => 'Kanji Arah & Lokasi'],
            ['name' => 'Grade 7', 'level_req' => 25, 'desc' => 'Kanji Abstrak & Sosial'],
        ];

        foreach ($grades as $index => $grade) {
            Stage::create([
                'name' => $grade['name'],
                'level_req' => $grade['level_req'],
                'monster_id' => $index + 1,
            ]);
        }
    }
}
