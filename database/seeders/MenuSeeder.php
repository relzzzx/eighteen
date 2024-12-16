<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $menus = [
            // Mang Ijul (Minuman)
            ['name' => 'Jus Strawberry', 'price' => 5000, 'booth_id' => 1, 'category' => 'minuman'],
            ['name' => 'Pop Ice', 'price' => 5000, 'booth_id' => 1, 'category' => 'minuman'],
            ['name' => 'Good Day', 'price' => 5000, 'booth_id' => 1, 'category' => 'minuman'],

            // Mul (Makanan)
            ['name' => 'Somay', 'price' => 1000, 'booth_id' => 2, 'category' => 'makanan'],
            ['name' => 'Batagor', 'price' => 1000, 'booth_id' => 2, 'category' => 'makanan'],
            ['name' => 'Kentang', 'price' => 1000, 'booth_id' => 2, 'category' => 'makanan'],

            // Bubur (Makanan)
            ['name' => 'Bubur tanpa sate', 'price' => 8000, 'booth_id' => 3, 'category' => 'makanan'],
            ['name' => 'Sate', 'price' => 2000, 'booth_id' => 3, 'category' => 'makanan'],

            // Roti Bakar (Makanan)
            ['name' => 'Roti Bakar Coklat', 'price' => 7000, 'booth_id' => 4, 'category' => 'makanan'],
            ['name' => 'Roti Bakar Coklat Tiramisu', 'price' => 10000, 'booth_id' => 4, 'category' => 'makanan'],

            // Pecel (Makanan)
            ['name' => 'Pecel Lele', 'price' => 10000, 'booth_id' => 5, 'category' => 'makanan'],
            ['name' => 'Pecel Ayam', 'price' => 14000, 'booth_id' => 5, 'category' => 'makanan'],

            // Pakde (Minuman)
            ['name' => 'Es Teh', 'price' => 5000, 'booth_id' => 6, 'category' => 'minuman'],
            ['name' => 'Es Jeruk', 'price' => 5000, 'booth_id' => 6, 'category' => 'minuman'],
            ['name' => 'Es Susu', 'price' => 5000, 'booth_id' => 6, 'category' => 'minuman'],

            // Bude Gorengan (Makanan)
            ['name' => 'Gorengan', 'price' => 2000, 'booth_id' => 7, 'category' => 'makanan'],
            ['name' => 'Nasi Goreng', 'price' => 10000, 'booth_id' => 7, 'category' => 'makanan'],

            // Ketoprak (Makanan)
            ['name' => 'Ketoprak', 'price' => 10000, 'booth_id' => 8, 'category' => 'makanan'],
            ['name' => 'Lontong Sayur', 'price' => 10000, 'booth_id' => 8, 'category' => 'makanan'],

            // Kebab (Makanan)
            ['name' => 'Kebab Telor', 'price' => 5000, 'booth_id' => 9, 'category' => 'makanan'],
            ['name' => 'Kebab Jumbo', 'price' => 15000, 'booth_id' => 9, 'category' => 'makanan'],
            ['name' => 'Burger', 'price' => 10000, 'booth_id' => 9, 'category' => 'makanan'],

            // Rames (Makanan)
            ['name' => 'Nasi Telor Balado', 'price' => 10000, 'booth_id' => 10, 'category' => 'makanan'],
            ['name' => 'Nasi Ikan', 'price' => 10000, 'booth_id' => 10, 'category' => 'makanan'],
            ['name' => 'Nasi Ayam', 'price' => 10000, 'booth_id' => 10, 'category' => 'makanan'],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
