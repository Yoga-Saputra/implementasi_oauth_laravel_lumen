<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PostsSeeder extends Seeder
{

    /**
     * Run the database seed.
     */
    public function run()
    {
        DB::table('posts')->insert([
            'user_id' => 1,
            'title' => 'Oauth2',
            'body'  => 'Implementation Oauth2',
        ]);
    }
}
