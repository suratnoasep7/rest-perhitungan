<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create('id_ID');

    	for($i = 1; $i <= 50; $i++){

    		DB::table('notes')->insert([
    			'title' => "Notes Title",
    			'content' => $faker->sentence(45),
    		]);
 
    	}

    }
    
}
