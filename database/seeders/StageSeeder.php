<?php

namespace Database\Seeders;

use App\Models\Chapter;
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
        $chapter = Chapter::first();
        if (!$chapter) {
            $chapter = Chapter::create([
                'title' => 'Bab 1: Permulaan',
                'chapter_number' => 1
            ]);
        }
        Stage::create([
            'chapter_id' => $chapter->id,
            'monster_id' => 1,
            'name' => 'Hari apa hari ini?',
            'description' => 'Kanji Dasar Hari dan Angka',
            'stage_number' => 1,
            'level_req' => 1,
            'is_boss_level' => false,
            'is_active' => true,
        ]);
    }
}
