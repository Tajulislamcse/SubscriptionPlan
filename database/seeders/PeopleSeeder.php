<?php

namespace Database\Seeders;

use App\Models\People;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
  
        Faker::create();

        for ($i=0; $i<100; $i++) {
            People::insert([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => fake()->phoneNumber(),
            ]);
        }
    }
    
}
