<?php

use App\Http\Controllers\ActionLogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserAjaxController;
use App\Http\Controllers\UserController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::redirect('/', 'auth/login-page');

Route::get('set-locale/{locale}', [LocaleController::class, "setlocale"])->name('setLocalize');
Route::middleware('LocalizationMiddleware')->group(function () {
    // AUTH
    Route::prefix('auth')->group(function () {
        Route::get("/login-page", [AuthController::class, "loginPage"])->name("auth.loginPage");
        Route::get("/register-page", [AuthController::class, "registerPage"])->name("auth.registerPage");
    });

    Route::middleware(['auth'])->group(function () {

        // Dashboard
        Route::prefix('dashboard')->group(function () {
            Route::get("index", [DashboardController::class, "index"])->name("dashboard.index");
        });

        // Carousel
        Route::prefix('carousel')->group(function () {
            Route::get("index", [CarouselController::class, "index"])->name("carousel.index");
            Route::post("create", [CarouselController::class, "create"])->name("carousel.create");
            Route::get("delete/{id}", [CarouselController::class, "delete"])->name("carousel.delete");
        });

        // Profile
        Route::prefix('profile')->group(function () {
            Route::get("read/{id}", [ProfileController::class, "read"])->name("profile.read");
            Route::get("edit/{id}", [ProfileController::class, "edit"])->name("profile.edit");
            Route::post("update/{id}", [ProfileController::class, "update"])->name("profile.update");
        });

        // Users
        Route::prefix('users')->group(function () {
            Route::get("index", [UserController::class, "index"])->name("users.index");
            Route::post("update/{id}", [UserController::class, "update"])->name("users.update");
            Route::get("delete/{id}", [UserController::class, "delete"])->name("users.delete");

            // Ajax
            Route::prefix('ajax')->group(function () {
                Route::get("sort-by-male", [UserAjaxController::class, "sortByMale"]);
                Route::get("sort-by-female", [UserAjaxController::class, "sortByFemale"]);
                Route::get("all-user", [UserAjaxController::class, "allUser"]);
            });
        });

        // Category
        Route::prefix('category')->group(function () {
            Route::get("index", [CategoryController::class, "index"])->name("category.index");
            Route::post("create", [CategoryController::class, "create"])->name("category.create");
            Route::get("edit/{id}", [CategoryController::class, "edit"])->name("category.edit");
            Route::post("update/{id}", [CategoryController::class, "update"])->name("category.update");
            Route::get("delete/{id}", [CategoryController::class, "delete"])->name("category.delete");
        });

        // Course
        Route::prefix('course')->group(function () {
            Route::get("index", [CourseController::class, "index"])->name("course.index");
            Route::post("create", [CourseController::class, "create"])->name("course.create");
            Route::get("create-index", [CourseController::class, "createIndex"])->name("course.createIndex");
            Route::get("read/{id}", [CourseController::class, "read"])->name("course.read");
            Route::get("edit/{id}", [CourseController::class, "edit"])->name("course.edit");
            Route::post("update/{id}", [CourseController::class, "update"])->name("course.update");
            Route::get("delete/{id}", [CourseController::class, "delete"])->name("course.delete");
        });

        // Trend Course
        Route::prefix('trend-course')->group(function () {
            Route::get("index", [ActionLogController::class, "index"])->name("trend-course.index");
        });

        // Author
        Route::prefix('author')->group(function () {
            Route::get("index", [AuthorController::class, "index"])->name("author.index");
            Route::get("create-index", [AuthorController::class, "createIndex"])->name("author.createIndex");
            Route::get("show", [AuthorController::class, "show"])->name("author.show");
            Route::post("create", [AuthorController::class, "create"])->name("author.create");
            Route::get("edit/{id}", [AuthorController::class, "edit"])->name("author.edit");
            Route::post("update/{id}", [AuthorController::class, "update"])->name("author.update");
            Route::get("delete/{id}", [AuthorController::class, "delete"])->name("author.delete");
        });

        // Lesson
        Route::prefix('lesson')->group(function () {
            Route::get("index", [LessonController::class, "index"])->name("lesson.index");
            Route::get("create-index", [LessonController::class, "createIndex"])->name("lesson.createIndex");
            Route::post("create", [LessonController::class, "create"])->name("lesson.create");
            Route::get("edit/{id}", [LessonController::class, "edit"])->name("lesson.edit");
            Route::post("update/{id}", [LessonController::class, "update"])->name("lesson.update");
            Route::get("delete/{id}", [LessonController::class, "delete"])->name("lesson.delete");
        });

        // Review
        Route::prefix('testimonial')->group(function () {
            Route::get("index", [TestimonialController::class, "index"])->name("testimonial.index");
            Route::get("delete/{id}", [TestimonialController::class, "delete"])->name("testimonial.delete");
        });

        // Blog
        Route::prefix('blog')->controller(BlogController::class)->group(function () {
            Route::get("index", "index")->name("blog.index");
            Route::post("create", "create")->name("blog.create");
            Route::get("edit/{id}", "edit")->name("blog.edit");
            Route::post("update/{id}", "update")->name("blog.update");
            Route::get("delete/{id}", "delete")->name("blog.delete");
        });
    });
});
