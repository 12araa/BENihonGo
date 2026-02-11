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
            'asset_path' => 'https://drive.google.com/file/d/1gytnJQFbB9KG4k5I5dCeMw3APRkH1BMn/view?usp=drive_link'
        ]);

        Item::create([
            'name' => 'Samurai Helmet',
            'type' => 'avatar',
            'price' => 500,
            'asset_path' => 'https://drive.google.com/file/d/1bhxlElaw6EK2QdeJxwDY-QNirYEw247V/view?usp=drive_link'
        ]);
    }
}
