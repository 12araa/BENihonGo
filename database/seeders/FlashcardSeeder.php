<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flashcard;

class FlashcardSeeder extends Seeder
{
    public function run(): void
    {
        $cards = [
            // ================= CHAPTER 1: ANGKA =================

            // --- Stage 1: Angka Dasar (1-5) ---
            ['stage_id' => 1, 'kanji' => '一', 'romaji' => 'Ichi', 'meaning' => 'Satu'],
            ['stage_id' => 1, 'kanji' => '二', 'romaji' => 'Ni', 'meaning' => 'Dua'],
            ['stage_id' => 1, 'kanji' => '三', 'romaji' => 'San', 'meaning' => 'Tiga'],
            ['stage_id' => 1, 'kanji' => '四', 'romaji' => 'Yon / Shi', 'meaning' => 'Empat'],
            ['stage_id' => 1, 'kanji' => '五', 'romaji' => 'Go', 'meaning' => 'Lima'],

            // --- Stage 2: Angka Lanjutan (6-10) ---
            ['stage_id' => 2, 'kanji' => '六', 'romaji' => 'Roku', 'meaning' => 'Enam'],
            ['stage_id' => 2, 'kanji' => '七', 'romaji' => 'Nana / Shichi', 'meaning' => 'Tujuh'],
            ['stage_id' => 2, 'kanji' => '八', 'romaji' => 'Hachi', 'meaning' => 'Delapan'],
            ['stage_id' => 2, 'kanji' => '九', 'romaji' => 'Kyuu', 'meaning' => 'Sembilan'],
            ['stage_id' => 2, 'kanji' => '十', 'romaji' => 'Juu', 'meaning' => 'Sepuluh'],

            // ================= CHAPTER 2: ELEMEN =================

            // --- Stage 5: Elemen Tata Surya ---
            ['stage_id' => 5, 'kanji' => '日', 'romaji' => 'Hi / Nichi', 'meaning' => 'Matahari / Hari'],
            ['stage_id' => 5, 'kanji' => '月', 'romaji' => 'Tsuki / Getsu', 'meaning' => 'Bulan'],
            ['stage_id' => 5, 'kanji' => '火', 'romaji' => 'Hi / Ka', 'meaning' => 'Api'],
            ['stage_id' => 5, 'kanji' => '水', 'romaji' => 'Mizu / Sui', 'meaning' => 'Air'],

            // --- Stage 6: Elemen Alam ---
            ['stage_id' => 6, 'kanji' => '木', 'romaji' => 'Ki / Moku', 'meaning' => 'Pohon / Kayu'],
            ['stage_id' => 6, 'kanji' => '金', 'romaji' => 'Kane / Kin', 'meaning' => 'Emas / Uang'],
            ['stage_id' => 6, 'kanji' => '土', 'romaji' => 'Tsuchi / Do', 'meaning' => 'Tanah'],

            // --- Stage 7: Geografi ---
            ['stage_id' => 7, 'kanji' => '山', 'romaji' => 'Yama', 'meaning' => 'Gunung'],
            ['stage_id' => 7, 'kanji' => '川', 'romaji' => 'Kawa', 'meaning' => 'Sungai'],
            ['stage_id' => 7, 'kanji' => '田', 'romaji' => 'Ta / Da', 'meaning' => 'Sawah'],

            // ================= CHAPTER 3: KEHIDUPAN =================

            // --- Stage 9: Orang & Tubuh ---
            ['stage_id' => 9, 'kanji' => '人', 'romaji' => 'Hito / Jin', 'meaning' => 'Orang'],
            ['stage_id' => 9, 'kanji' => '口', 'romaji' => 'Kuchi', 'meaning' => 'Mulut'],
            ['stage_id' => 9, 'kanji' => '目', 'romaji' => 'Me', 'meaning' => 'Mata'],

            // --- Stage 10: Waktu & Jam ---
            ['stage_id' => 10, 'kanji' => '時', 'romaji' => 'Ji', 'meaning' => 'Jam (Waktu)'],
            ['stage_id' => 10, 'kanji' => '分', 'romaji' => 'Fun / Pun', 'meaning' => 'Menit'],
            ['stage_id' => 10, 'kanji' => '半', 'romaji' => 'Han', 'meaning' => 'Setengah'],
        ];

        foreach ($cards as $card) {
            Flashcard::create($card);
        }
    }
}
