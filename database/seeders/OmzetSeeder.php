<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Omzet;

class OmzetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Omzet::insert([
            [
                'total_omzet' => 100000000,
                'komisi'    => 0,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'total_omzet' => 200000000,
                'komisi'    => 2.5,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'total_omzet' => 500000000,
                'komisi'    => 5,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'total_omzet' => 500000000,
                'komisi'    => 10,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]
        ]);
    }
}
