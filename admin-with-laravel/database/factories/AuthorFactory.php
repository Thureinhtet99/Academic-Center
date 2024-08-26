<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_name' => $this->faker->name(),
            'author_email' => $this->faker->unique()->safeEmail(),
            'author_phone' => $this->faker->phoneNumber(),
            'author_birthday' => $this->faker->date(),
            'author_gender' => $this->faker->randomElement(["male", "female"]),
            'author_degree' => $this->faker->jobTitle(),
            'author_about' => $this->faker->paragraph(),

        ];
    }
}
