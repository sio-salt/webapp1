<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::table('users')->insert([
            'name' => '山大 太郎',
            'profile' => 'profile text goes here',
            'university_id' => 1,
            'faculty_id' => 1,
            'grade' => 4,
            ''
        ]);
    }
}
