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
            [
                'stage_id' => 1,
                'question' => 'Kanji "川" artinya adalah...',
                'options' => ['Gunung', 'Sawah', 'Sungai', 'Langit'],
                'correct_answer' => 'Sungai',
            ],

            [
                'stage_id' => 1,
                'question' => 'Lengkapi: "Ano hito wa ... (山) ni noborimasu."',
                'options' => ['Kawa', 'Yama', 'Ta', 'Hi'],
                'correct_answer' => 'Yama',
            ],

            [
                'stage_id' => 1,
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
