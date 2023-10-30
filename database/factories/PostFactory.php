<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 理学部物理太郎用のシーディング用のfactory
            'user_id' => 1,
            'title' => '場の量子論レポート課題を解く会',
            'lecture_id' => 1,
            'tag_id' => 1,
            'faculty_id' => 1,
            'start_at' => $this->faker->dateTime,
            'place' => '理学部1号館1階122教室',
            'body' => '今回のレポートは大変そう! 一緒に解きたい人は気軽に来てください!',
            'image_url' => $this->faker->imageUrl(),
            'teacher_welcome' => $this->faker->boolean,
        ];
    }
}
