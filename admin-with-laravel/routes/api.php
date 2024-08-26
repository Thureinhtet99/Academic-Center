<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\AuthorApiController;
use App\Http\Controllers\Api\CourseApiController;
use App\Http\Controllers\Api\LessonApiController;
use App\Http\Controllers\Api\CommentApiController;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\Api\CarouselApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ActionLogApiController;
use App\Http\Controllers\Api\BlogActionLogApiController;
use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\Api\CommentLikeCountApiController;
use App\Http\Controllers\Api\CompletedLessonController;
use App\Http\Controllers\Api\OwnCourseApiController;
use App\Http\Controllers\Api\TestimonialsApiController;
use App\Http\Controllers\Api\TestimonialsLikeCountApiController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Auth
Route::prefix('auth')->group(function () {
    Route::post("check-user", [AuthApiController::class, "checkUser"]);
    Route::post("register", [AuthApiController::class, "register"]);
    Route::post("login", [AuthApiController::class, "login"]);
    Route::post("google-login", [AuthApiController::class, "googleLogin"]);
});

// Category
Route::apiResource("/categories", CategoryApiController::class);

// Carousel
Route::apiResource("/carousels", CarouselApiController::class);

// Course
Route::apiResource("/courses", CourseApiController::class);
Route::post("/course/filter", [CourseApiController::class, "filterByCategory"]);
Route::post("/course/show", [CourseApiController::class, "showCourse"]);

// Author
Route::get("/authors", [AuthorApiController::class, "index"]);
Route::post("/author/show", [AuthorApiController::class, "show"]);

// User
Route::apiResource("/users", UserApiController::class);

// Lesson
Route::post("/lesson/show", [LessonApiController::class, "show"]);

// Completed Lesson
Route::get("/completed-lessons", [CompletedLessonController::class, "index"]);
Route::post("/completed-lesson/show", [CompletedLessonController::class, "show"]);
Route::post("/completed-lesson/check-completed-lesson", [CompletedLessonController::class, "checkCompletedLesson"]);

// Comment
Route::post("/comment/store", [CommentApiController::class, "store"]);
Route::post("/comment/show", [CommentApiController::class, "show"]);
Route::post("/comment/destroy", [CommentApiController::class, "destroy"]);

// Comment like count
Route::get("/comment-like-counts", [CommentLikeCountApiController::class, "index"]);
Route::post("/comment-like-count/show", [CommentLikeCountApiController::class, "show"]);
Route::post("/comment-like-count/check-like", [CommentLikeCountApiController::class, "checkLike"]);

// Profile
Route::post("/profile/show", [ProfileApiController::class, "show"]);
Route::post("/profile/update", [ProfileApiController::class, "update"]);
Route::post("/profile/update-profile-image", [ProfileApiController::class, "updateProfileImg"]);
Route::post("/profile/update-social-links", [ProfileApiController::class, "updateSocialLink"]);
Route::post("/profile/update-password", [ProfileApiController::class, "updatePassword"]);

// Action Log
Route::get("/action-logs", [ActionLogApiController::class, "index"]);
Route::post("/action-log/store", [ActionLogApiController::class, "store"]);

// Own Course
Route::post("/own-course/show", [OwnCourseApiController::class, "show"]);
Route::post("/own-course/store", [OwnCourseApiController::class, "store"]);

// Testimonials
Route::get("/testimonials", [TestimonialsApiController::class, "index"]);
Route::post("/testimonial/show", [TestimonialsApiController::class, "show"]);
Route::post("/testimonial/store", [TestimonialsApiController::class, "store"]);
Route::post("/testimonial/destroy", [TestimonialsApiController::class, "destroy"]);

// Testimonials Like Count
Route::get("/testimonial-like-counts", [TestimonialsLikeCountApiController::class, "index"]);
Route::post("/testimonial-like-counts/show", [TestimonialsLikeCountApiController::class, "show"]);
Route::post("/testimonial-like-counts/check-like", [TestimonialsLikeCountApiController::class, "checkLike"]);

// Blogs
Route::get("/blogs", [BlogApiController::class, "index"]);
Route::post("/blog/show", [BlogApiController::class, "show"]);
Route::post("/blog/show/related-blogs", [BlogApiController::class, "relatedBlogShow"]);

// Blog action log
Route::get("/blog-action-logs", [BlogActionLogApiController::class, "index"]);
Route::post("/blog-action-logs/store", [BlogActionLogApiController::class, "store"]);
