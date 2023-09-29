<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create(

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            FacultySeeder::class,
            MajorSeeder::class,
            UserSeeder::class,
            LectureSeeder::class,
            LectureUserSeeder::class,
            PostSeeder::class,
            PostUserParticipations::class,
            LecturePost::class,
            MajorPost::class,
        ]);
    }
}
