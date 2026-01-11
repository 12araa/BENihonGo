<?php

namespace Database\Seeders;

use App\Models\Flashcard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlashcardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kanjis_grade_1 = [
            ['kanji' => '一', 'romaji' => 'Ichi', 'meaning' => 'Satu'],
            ['kanji' => '二', 'romaji' => 'Ni', 'meaning' => 'Dua'],
            ['kanji' => '三', 'romaji' => 'San', 'meaning' => 'Tiga'],
            ['kanji' => '日', 'romaji' => 'Hi / Nichi', 'meaning' => 'Matahari / Hari'],
            ['kanji' => '月', 'romaji' => 'Tsuki / Gatsu', 'meaning' => 'Bulan'],
        ];

        foreach ($kanjis_grade_1 as $k) {
            Flashcard::create([
                'stage_id' => 1,
                'kanji' => $k['kanji'],
                'romaji' => $k['romaji'],
                'meaning' => $k['meaning'],
                'audio_path' => null
            ]);
        }
        // === MATERI GRADE 2 (Stage ID: 2) ===
        Flashcard::create(['stage_id' => 2, 'kanji' => '人', 'romaji' => 'Hito', 'meaning' => 'Orang']);
        Flashcard::create(['stage_id' => 2, 'kanji' => '口', 'romaji' => 'Kuchi', 'meaning' => 'Mulut']);
    }
}
