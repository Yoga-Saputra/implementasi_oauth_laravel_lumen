<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{

    /**
     * Run the database seed.
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'server',
            'email' => 'server@gmail.com',
            'password'  => Hash::make('server123'),
        ]);
    }
}
