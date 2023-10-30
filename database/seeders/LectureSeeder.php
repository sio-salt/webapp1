<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class LectureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* DB::table('lectures')->insert([ */
        /*     'name' => '場の量子論', */
        /*     'faculty_id' => 1, */
        /* ]); */
        
        $lecture_names = file('/home/ec2-user/environment/webapp/database/seeders/first_plus_second_uniq_lectures', FILE_IGNORE_NEW_LINES);
        foreach ($lecture_names as $lecture_name) {
            DB::table('lectures')->insert([
                'name' => $lecture_name,
            ]);
        }
    }
}
