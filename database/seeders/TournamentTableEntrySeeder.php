<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TournamentTableEntry;

class TournamentTableEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TournamentTableEntry::factory()
            ->count(5)
            ->create();
    }
}
