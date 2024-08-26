<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => rand(1, 10),
            'author_id' => rand(1, 5),
            'course_title' => $this->faker->word(),
            'course_description' => $this->faker->paragraph(),
            'course_duration' => rand(1, 12),
            'course_price' => $this->faker->numberBetween(0, 9000),
            'course_about' => $this->faker->paragraph(),
        ];
    }
}
