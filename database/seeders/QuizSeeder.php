<?php

namespace Database\Seeders;

use App\Models\Quiz;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Quiz::truncate();
        Schema::enableForeignKeyConstraints();

        $quizzes = [
            // ==========================================
            // STAGE 1: HEWAN (Dasar)
            // ==========================================

            // Tipe 1: To The Point (Langsung Kanji -> Arti)
            [
                'stage_id' => 1,
                'question' => 'Apa arti dari Kanji "猫"?',
                'options' => ['Anjing', 'Kucing', 'Burung', 'Ikan'],
                'correct_answer' => 'Kucing',
            ],

            // Tipe 2: Soal Cerita / Kalimat Rumpang (Melengkapi)
            // Soal: "Di sana ada ... (Anjing)."
            [
                'stage_id' => 1,
                'question' => 'Lengkapi kalimat ini: "Asoko ni ... (犬) ga imasu."',
                'options' => ['Neko (Kucing)', 'Inu (Anjing)', 'Tori (Burung)', 'Uma (Kuda)'],
                'correct_answer' => 'Inu (Anjing)',
            ],

            // Tipe 3: Reading (Romaji -> Kanji)
            [
                'stage_id' => 1,
                'question' => 'Manakah Kanji yang dibaca "Tori"?',
                'options' => ['犬', '猫', '魚', '鳥'],
                'correct_answer' => '鳥',
            ],

            // ==========================================
            // STAGE 2: ALAM (Nature)
            // ==========================================

            // Tipe 1: To The Point
            [
                'stage_id' => 2,
                'question' => 'Kanji "川" artinya adalah...',
                'options' => ['Gunung', 'Sawah', 'Sungai', 'Langit'],
                'correct_answer' => 'Sungai',
            ],

            // Tipe 2: Soal Cerita (Contextual)
            // Soal: "Orang itu sedang mendaki ... (Gunung)"
            [
                'stage_id' => 2,
                'question' => 'Lengkapi: "Ano hito wa ... (山) ni noborimasu."',
                'options' => ['Kawa', 'Yama', 'Ta', 'Hi'],
                'correct_answer' => 'Yama',
            ],

             // Tipe 3: Tebak Gambar/Situasi (Deskriptif)
            [
                'stage_id' => 2,
                'question' => 'Manakah Kanji yang melambangkan "Sawah"?',
                'options' => ['田', '口', '日', '目'],
                'correct_answer' => '田',
            ],
        ];

        foreach ($quizzes as $quiz) {
            Quiz::create($quiz);
        }
    }
}
