<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RegisterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('tb_register')->insert([
                'nama_depan' => $faker->firstName,
                'nama_belakang' => $faker->lastName,
                'alamat' => $faker->address,
                'no_wa' => $faker->phoneNumber,
                'kecamatan' => $faker->city,
                'kelurahan' => $faker->streetName,
                'rekomendasi' => $faker->sentence,
                'paket' => $faker->numberBetween(1, 10),
                'status' => $faker->randomElement([0, 1]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
