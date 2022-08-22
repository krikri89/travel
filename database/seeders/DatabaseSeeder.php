<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $faker = Faker::create();

        foreach (range(1, 20) as $_) {
            DB::table('countries')->insert([
                'country' => $faker->country(),
            ]);
        }

        foreach (range(1, 20) as $_) {
            DB::table('hotels')->insert([
                'hotel' => $faker->company(),
                'price' => rand(300, 999),
                'period' => $faker->monthName(),
                'photo' => $faker->image(),
                'country_id' => rand(1, 9)

            ]);
        }

        DB::table('users')->insert([
            'name' => 'bebras',
            'email' => 'bebras@gmail.com',
            'password' => Hash::make('123'),
        ]);

        DB::table('users')->insert([
            'name' => 'briedis',
            'email' => 'briedis@gmail.com',
            'password' => Hash::make('123'),
            'role' => 10,
        ]);
    }
}
