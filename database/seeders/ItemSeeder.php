<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::create([
            'name' => 'Novice Headband',
            'type' => 'avatar',
            'price' => 0,
            'asset_path' => 'avatars/headband.png'
        ]);

        Item::create([
            'name' => 'Samurai Helmet',
            'type' => 'avatar',
            'price' => 500,
            'asset_path' => 'avatars/samurai_helm.png'
        ]);
    }
}
