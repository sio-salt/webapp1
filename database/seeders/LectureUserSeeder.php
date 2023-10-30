<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LectureUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lecture_user')->insert([
            'lecture_id' => 1,
            'user_id' => 1,
            'is_taking_lecture' => 0,
        ]);
    }
}
