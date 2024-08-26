<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "course_id" => rand(1, 20),
            "lesson_name" => $this->faker->word(),
            "lesson_description" => $this->faker->paragraph(),
            "lesson_video" => $this->faker->url(),
        ];
    }
}
