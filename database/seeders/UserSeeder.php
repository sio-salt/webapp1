<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => '理学部物理太郎',
            'profile' => 'シーディングのために入れられた理学部物理選考の太郎です。',
            'profile_picture_url' => null,
            'faculty_id' => 1,
            'major_id' => 1,
            'grade' => 5,
            'lab' => null,
            'email' => 'saltinthedesertyou@gmail.com',
            'password' => bcrypt('3Sa8la5ga2ta')
        ]);
    }
}
