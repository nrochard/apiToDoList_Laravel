<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory; 

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++){
            DB::table('tasks')->insert([
                'body' => $faker->text,
                'user_id' => $faker->numberBetween($min = 1, $max = 10),
                'done' => $faker->numberBetween($min = 0, $max = 1),
            ]);
        }

    }
}
