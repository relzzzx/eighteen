<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booth;

class BoothSeeder extends Seeder
{
    public function run()
    {
        $booths = [
            ['name' => 'Mang Ijul', 'description' => 'Minuman segar', 'user_id' => 2, 'status' => true],
            ['name' => 'Mul', 'description' => 'Makanan tradisional', 'user_id' => 3, 'status' => true],
            ['name' => 'Bubur', 'description' => 'Bubur dan sate', 'user_id' => 4, 'status' => true],
            ['name' => 'Roti Bakar', 'description' => 'Roti bakar berbagai rasa', 'user_id' => 5, 'status' => true],
            ['name' => 'Pecel', 'description' => 'Aneka pecel', 'user_id' => 6, 'status' => true],
            ['name' => 'Pakde', 'description' => 'Minuman dingin', 'user_id' => 7, 'status' => true],
            ['name' => 'Bude Gorengan', 'description' => 'Gorengan dan nasi goreng', 'user_id' => 8, 'status' => true],
            ['name' => 'Ketoprak', 'description' => 'Ketoprak dan lontong sayur', 'user_id' => 9, 'status' => true],
            ['name' => 'Kebab', 'description' => 'Kebab dan burger', 'user_id' => 10, 'status' => true],
            ['name' => 'Rames', 'description' => 'Makanan lengkap', 'user_id' => 11, 'status' => true],
        ];

        foreach ($booths as $booth) {
            Booth::create($booth);
        }
    }
}
