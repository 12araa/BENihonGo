<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chapter;

class ChapterSeeder extends Seeder
{
    public function run(): void
    {
        // Kita sesuaikan dengan kolom: title & chapter_number
        $chapters = [
            [
                'id' => 1,
                'title' => 'Scroll Angka Kuno',
                'chapter_number' => 1,
            ],
            [
                'id' => 2,
                'title' => 'Kuil Elemen Alam',
                'chapter_number' => 2,
            ],
            [
                'id' => 3,
                'title' => 'Kehidupan Desa',
                'chapter_number' => 3,
            ],
        ];

        foreach ($chapters as $chapter) {
            Chapter::create($chapter);
        }
    }
}
