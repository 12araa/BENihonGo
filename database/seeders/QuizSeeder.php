<?php

namespace Database\Seeders;

use App\Models\Quiz;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Quiz::truncate();
        Schema::enableForeignKeyConstraints();

        $quizzes = [
            // ================= CHAPTER 1: ANGKA =================

            // --- Stage 1: Angka Dasar (1-5) ---
            [
                'stage_id' => 1,
                'question' => 'Kanji "一" artinya adalah...',
                'options' => ['Satu', 'Dua', 'Tiga', 'Empat'],
                'correct_answer' => 'Satu',
            ],
            [
                'stage_id' => 1,
                'question' => 'Manakah kanji untuk angka "Tiga"?',
                'options' => ['一', '二', '三', '四'],
                'correct_answer' => '三',
            ],
            [
                'stage_id' => 1,
                'question' => 'Kanji "Lima" ditulis dengan...',
                'options' => ['五', '五十', 'Go', 'Wu'],
                'correct_answer' => '五',
            ],

            // --- Stage 2: Angka Lanjutan (6-10) ---
            [
                'stage_id' => 2,
                'question' => 'Kanji "八" dibaca...',
                'options' => ['Hachi', 'Nana', 'Roku', 'Kyuu'],
                'correct_answer' => 'Hachi',
            ],
            [
                'stage_id' => 2,
                'question' => 'Apa arti kanji "十"?',
                'options' => ['Tujuh', 'Delapan', 'Sembilan', 'Sepuluh'],
                'correct_answer' => 'Sepuluh',
            ],
            [
                'stage_id' => 2,
                'question' => 'Urutan setelah "Roku" (6) adalah...',
                'options' => ['Hachi (8)', 'Nana (7)', 'Juu (10)', 'Go (5)'],
                'correct_answer' => 'Nana (7)',
            ],

            // --- Stage 3: Puluhan & Ratusan ---
            [
                'stage_id' => 3,
                'question' => 'Angka "20" dalam kanji ditulis...',
                'options' => ['二十', '十二', '二一', '十二'],
                'correct_answer' => '二十',
            ],
            [
                'stage_id' => 3,
                'question' => 'Kanji "百" artinya?',
                'options' => ['Puluh', 'Ratus', 'Ribu', 'Juta'],
                'correct_answer' => 'Ratus',
            ],
            [
                'stage_id' => 3,
                'question' => 'Jika "San" = 3, maka "300" adalah...',
                'options' => ['三百 (Sanbyaku)', '三千 (Sanzen)', '三十 (Sanjuu)', '三 (San)'],
                'correct_answer' => '三百 (Sanbyaku)',
            ],

            // --- Stage 4: Ujian Matematika Ninja (BOSS - 6 Soal) ---
            [
                'stage_id' => 4,
                'question' => 'Berapa jumlah garis pada kanji "二"?',
                'options' => ['1 Garis', '2 Garis', '3 Garis', '4 Garis'],
                'correct_answer' => '2 Garis',
            ],
            [
                'stage_id' => 4,
                'question' => 'Lengkapi: Ichi, Ni, ..., Yon.',
                'options' => ['Go', 'Roku', 'San', 'Nana'],
                'correct_answer' => 'San',
            ],
            [
                'stage_id' => 4,
                'question' => 'Kanji untuk "15" adalah...',
                'options' => ['十五', '五十', '一五', '五一'],
                'correct_answer' => '十五',
            ],
            [
                'stage_id' => 4,
                'question' => 'Manakah yang BUKAN angka?',
                'options' => ['四', '七', '円', '九'],
                'correct_answer' => '円',
            ],
            [
                'stage_id' => 4,
                'question' => 'Hasil dari "二 + 三" (2 + 3) adalah...',
                'options' => ['四 (4)', '五 (5)', '六 (6)', '七 (7)'],
                'correct_answer' => '五 (5)',
            ],
            [
                'stage_id' => 4,
                'question' => 'Kanji "Hyaku" artinya...',
                'options' => ['10', '100', '1000', '10000'],
                'correct_answer' => '100',
            ],

            // ================= CHAPTER 2: ELEMEN =================

            // --- Stage 5: Elemen Tata Surya ---
            [
                'stage_id' => 5,
                'question' => 'Kanji "日" memiliki arti...',
                'options' => ['Bulan', 'Matahari', 'Bintang', 'Langit'],
                'correct_answer' => 'Matahari',
            ],
            [
                'stage_id' => 5,
                'question' => 'Elemen "Air" ditulis dengan kanji?',
                'options' => ['火', '水', '木', '金'],
                'correct_answer' => '水',
            ],
            [
                'stage_id' => 5,
                'question' => 'Lawan dari elemen "Api" (火) adalah...',
                'options' => ['Air (水)', 'Tanah (土)', 'Emas (金)', 'Matahari (日)'],
                'correct_answer' => 'Air (水)',
            ],

            // --- Stage 6: Elemen Alam ---
            [
                'stage_id' => 6,
                'question' => 'Kanji "木" (Pohon) dibaca...',
                'options' => ['Ki', 'Hi', 'Mizu', 'Tsuchi'],
                'correct_answer' => 'Ki',
            ],
            [
                'stage_id' => 6,
                'question' => 'Manakah kanji untuk "Emas/Uang"?',
                'options' => ['土', '金', '木', '水'],
                'correct_answer' => '金',
            ],
            [
                'stage_id' => 6,
                'question' => 'Kanji "土" (Tanah) mirip dengan kanji angka...',
                'options' => ['Sepuluh (十)', 'Satu (一)', 'Dua (二)', 'Lima (五)'],
                'correct_answer' => 'Sepuluh (十)',
            ],

            // --- Stage 7: Geografi ---
            [
                'stage_id' => 7,
                'question' => 'Kanji "山" artinya...',
                'options' => ['Sungai', 'Gunung', 'Sawah', 'Laut'],
                'correct_answer' => 'Gunung',
            ],
            [
                'stage_id' => 7,
                'question' => 'Lengkapi: Ano hito wa ... (川) de oyogimasu.',
                'options' => ['Yama', 'Kawa', 'Ta', 'Hi'],
                'correct_answer' => 'Kawa',
            ],
            [
                'stage_id' => 7,
                'question' => 'Manakah yang artinya "Sawah"?',
                'options' => ['田', '口', '日', '目'],
                'correct_answer' => '田',
            ],

            // --- Stage 8: Boss Pengendali Elemen (BOSS - 7 Soal) ---
            [
                'stage_id' => 8,
                'question' => 'Manakah kanji untuk "API"?',
                'options' => ['水', '火', '土', '金'],
                'correct_answer' => '火',
            ],
            [
                'stage_id' => 8,
                'question' => 'Gabungan kanji "Gunung Api" adalah...',
                'options' => ['火山', '水田', '木川', '金土'],
                'correct_answer' => '火山',
            ],
            [
                'stage_id' => 8,
                'question' => 'Hari Minggu ditulis "Nichiyoubi" (Hari Matahari). Kanjinya adalah...',
                'options' => ['日曜日', '月曜日', '火曜日', '水曜日'],
                'correct_answer' => '日曜日',
            ],
            [
                'stage_id' => 8,
                'question' => 'Kanji "Bulan" adalah...',
                'options' => ['月', '日', '明', '木'],
                'correct_answer' => '月',
            ],
            [
                'stage_id' => 8,
                'question' => 'Manakah pasangan yang BENAR?',
                'options' => ['水 = Api', '木 = Pohon', '土 = Emas', '金 = Tanah'],
                'correct_answer' => '木 = Pohon',
            ],
            [
                'stage_id' => 8,
                'question' => 'Kanji "Yama" (Gunung) memiliki berapa garis?',
                'options' => ['2', '3', '4', '5'],
                'correct_answer' => '3',
            ],
            [
                'stage_id' => 8,
                'question' => 'Air di Sungai = ...',
                'options' => ['川の水 (Kawa no Mizu)', '山の火 (Yama no Hi)', '田の土 (Ta no Tsuchi)', '木の金 (Ki no Kane)'],
                'correct_answer' => '川の水 (Kawa no Mizu)',
            ],

            // ================= CHAPTER 3: KEHIDUPAN =================

            // --- Stage 9: Orang & Tubuh ---
            [
                'stage_id' => 9,
                'question' => 'Kanji "人" dibaca...',
                'options' => ['Hito', 'Kuchi', 'Me', 'Mimi'],
                'correct_answer' => 'Hito',
            ],
            [
                'stage_id' => 9,
                'question' => 'Apa arti kanji "口"?',
                'options' => ['Mata', 'Telinga', 'Mulut', 'Hidung'],
                'correct_answer' => 'Mulut',
            ],
            [
                'stage_id' => 9,
                'question' => 'Ada 3 orang = ...',
                'options' => ['三人 (Sannin)', '三口 (Sankuchi)', '三日 (Mikka)', '三目 (Sanme)'],
                'correct_answer' => '三人 (Sannin)',
            ],

            // --- Stage 10: Waktu & Jam ---
            [
                'stage_id' => 10,
                'question' => 'Kanji untuk "Jam/Waktu" adalah...',
                'options' => ['分', '時', '半', '午'],
                'correct_answer' => '時',
            ],
            [
                'stage_id' => 10,
                'question' => 'Kanji "分" artinya...',
                'options' => ['Jam', 'Detik', 'Menit', 'Tahun'],
                'correct_answer' => 'Menit',
            ],
            [
                'stage_id' => 10,
                'question' => 'Jam 3 (San-ji) ditulis...',
                'options' => ['三時', '三分', '三月', '三日'],
                'correct_answer' => '三時',
            ],

            // --- Stage 11: Survival Desa (BOSS - 6 Soal) ---
            [
                'stage_id' => 11,
                'question' => 'Manakah kanji untuk "Mata"?',
                'options' => ['目', '口', '人', '耳'],
                'correct_answer' => '目',
            ],
            [
                'stage_id' => 11,
                'question' => 'Gabungan "Orang Jepang" adalah...',
                'options' => ['日本人', '日本日', '本一人', '月火水'],
                'correct_answer' => '日本人',
            ],
            [
                'stage_id' => 11,
                'question' => '"Mulut Orang" (Populasi) ditulis...',
                'options' => ['人口 (Jinkou)', '人目 (Hitome)', '口人 (Kuchibito)', '目口 (Mekuchi)'],
                'correct_answer' => '人口 (Jinkou)',
            ],
            [
                'stage_id' => 11,
                'question' => 'Satu Jam = ...',
                'options' => ['一時間 (Ichijikan)', '一分 (Ippun)', '一日 (Ichinichi)', '一月 (Ichigatsu)'],
                'correct_answer' => '一時間 (Ichijikan)',
            ],
            [
                'stage_id' => 11,
                'question' => 'Manakah kanji yang berkaitan dengan tubuh manusia?',
                'options' => ['目', '川', '山', '田'],
                'correct_answer' => '目',
            ],
            [
                'stage_id' => 11,
                'question' => 'Pukul 10:30 (Juu-ji Han). Kanji "Han" (Setengah) adalah...',
                'options' => ['半', '分', '時', '午'],
                'correct_answer' => '半',
            ],
        ];

        foreach ($quizzes as $quiz) {
            Quiz::create($quiz);
        }
    }
}
