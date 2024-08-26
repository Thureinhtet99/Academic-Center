<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ActionLog;
use App\Models\User;
use App\Models\Author;
use App\Models\Blog;
use App\Models\BlogActionLog;
use App\Models\Course;
use App\Models\Category;
use App\Models\Lesson;
use App\Models\OwnCourse;
use App\Models\Review;
use App\Models\TestimonialLikeCount;
use App\Models\Testimonials;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Author::factory()->count(5)->create();
        Category::factory()->count(10)->create();
        Course::factory()->count(20)->create();
        ActionLog::factory()->count(80)->create();
        OwnCourse::factory()->count(20)->create();
        Lesson::factory()->count(60)->create();
        Review::factory()->count(80)->create();
        Testimonials::factory()->count(100)->create();
        TestimonialLikeCount::factory()->count(150)->create();
        Blog::factory()->count(40)->create();
        BlogActionLog::factory()->count(80)->create();

        // Admin
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'gender' => 'male',
            'role' => "admin",
            'password' => Hash::make('admin12345'),
        ]);

        User::factory()->create([
            "name" => "Alice",
            "email" => "alice@gmail.com",
            'role' => "user",
            'gender' => "female",
        ]);
        User::factory()->create([
            "name" => "Bob",
            "email" => "bob@gmail.com",
            'role' => "user",
            'gender' => "male",
        ]);
        User::factory()->create([
            "name" => "David",
            "email" => "david@gmail.com",
            'role' => "user",
            'gender' => "male",
        ]);
    }
}
