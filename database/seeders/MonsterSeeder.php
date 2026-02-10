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
                'asset_path' => 'https://imgur.com/a/ypPStg4',
                'base_hp' => 50,
                'damage_per_hit' => 5,
                'exp_reward' => 10,
                'gold_reward' => 5,
            ],
            [
                'name' => 'Slime Merah',
                'asset_path' => 'https://imgur.com/a/0EpMF2k',
                'base_hp' => 75,
                'damage_per_hit' => 10,
                'exp_reward' => 20,
                'gold_reward' => 10,
            ],
            [
                'name' => 'Kelelawar',
                'asset_path' => 'https://imgur.com/a/aSbWA9F',
                'base_hp' => 100,
                'damage_per_hit' => 15,
                'exp_reward' => 30,
                'gold_reward' => 15,
            ],
            [
                'name' => 'Golem Batu',
                'asset_path' => 'https://imgur.com/a/vW3fCh3',
                'base_hp' => 200,
                'damage_per_hit' => 10,
                'exp_reward' => 50,
                'gold_reward' => 30,
            ],
            [
                'name' => 'Golem Batu Merah',
                'asset_path' => 'https://imgur.com/a/K6UNNML',
                'base_hp' => 300,
                'damage_per_hit' => 15,
                'exp_reward' => 80,
                'gold_reward' => 50,
            ],
            [
                'name' => 'Monster Pohon',
                'asset_path' => 'https://imgur.com/a/dOvBn8E',
                'base_hp' => 450,
                'damage_per_hit' => 20,
                'exp_reward' => 120,
                'gold_reward' => 80,
            ],
            [
                'name' => 'Raja Iblis',
                'asset_path' => 'https://imgur.com/a/1HdF1So',
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
