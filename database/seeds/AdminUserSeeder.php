<?php

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'marc mendoza',
            'email' => '777marc@gmail.com',
            'password' => Hash::make('marc1111')
        ]);
    }
}
