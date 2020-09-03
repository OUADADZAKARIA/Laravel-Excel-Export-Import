<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i=0; $i < 20; $i++) {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@regimeaz.com',
            'password' => Hash::make('password'),
        ]);
        }
    }
}

