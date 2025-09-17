<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 季節データを先に作成
        $this->call([
            SeasonSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
