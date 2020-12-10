<?php

namespace Database\Seeders;

use App\Models\Meet;
use Illuminate\Database\Seeder;

class MeetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Meet::factory()
            ->count(5)
            ->create();
    }
}
