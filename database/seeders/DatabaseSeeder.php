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
        $this->call([
            NotesSeeder::class,
            MarketingSeeder::class,
            PenjualanSeeder::class,
            OmzetSeeder::class
        ]);
    }
}
