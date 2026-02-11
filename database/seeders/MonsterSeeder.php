<?php

namespace Database\Seeders;

use App\Models\Monster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonsterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $monsters = [
            [
                'name' => 'Slime Hijau',
                'asset_path' => 'https://drive.google.com/file/d/1J35FNm6drHmeAYGkya_gWT-cDcsFnG_0/view?usp=drive_link',
                'base_hp' => 50,
                'damage_per_hit' => 5,
                'exp_reward' => 10,
                'gold_reward' => 5,
            ],
            [
                'name' => 'Slime Merah',
                'asset_path' => 'https://drive.google.com/file/d/1u_F_8z9ZUGuxhs3A36NqTo9vPgXR-i_A/view?usp=drive_link',
                'base_hp' => 75,
                'damage_per_hit' => 10,
                'exp_reward' => 20,
                'gold_reward' => 10,
            ],
            [
                'name' => 'Kelelawar',
                'asset_path' => 'https://drive.google.com/file/d/1DWUs49TXsnPDyb63hXZShiTFA6b7MqJr/view?usp=drive_link',
                'base_hp' => 100,
                'damage_per_hit' => 15,
                'exp_reward' => 30,
                'gold_reward' => 15,
            ],
            [
                'name' => 'Golem Batu',
                'asset_path' => 'https://drive.google.com/file/d/1kGdjBhDqtgyOBUgSV6AYfLN0DaeHPF-a/view?usp=sharing',
                'base_hp' => 200,
                'damage_per_hit' => 10,
                'exp_reward' => 50,
                'gold_reward' => 30,
            ],
            [
                'name' => 'Golem Batu Merah',
                'asset_path' => 'https://drive.google.com/file/d/1oiyhscWPCkX0dka8FvjkUNSZtdb7Lm4l/view?usp=drive_link',
                'base_hp' => 300,
                'damage_per_hit' => 15,
                'exp_reward' => 80,
                'gold_reward' => 50,
            ],
            [
                'name' => 'Monster Pohon',
                'asset_path' => 'https://drive.google.com/file/d/1rF-IowMBg_4KedPBNE-t4np76iDqLjxA/view?usp=drive_link',
                'base_hp' => 450,
                'damage_per_hit' => 20,
                'exp_reward' => 120,
                'gold_reward' => 80,
            ],
            [
                'name' => 'Raja Iblis',
                'asset_path' => 'https://drive.google.com/file/d/1Yd0ebhW10BocbrACEoJNkgA8K015FYHQ/view?usp=drive_link',
                'base_hp' => 650,
                'damage_per_hit' => 35,
                'exp_reward' => 500,
                'gold_reward' => 300,
            ]
        ];

        foreach ($monsters as $monster) {
            Monster::create($monster);
        }
    }
}
