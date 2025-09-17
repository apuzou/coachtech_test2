<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seasons = [
            ['name' => '春'],
            ['name' => '夏'],
            ['name' => '秋'],
            ['name' => '冬']
        ];

        foreach ($seasons as $season) {
            \App\Models\Season::create($season);
        }
    }
}
