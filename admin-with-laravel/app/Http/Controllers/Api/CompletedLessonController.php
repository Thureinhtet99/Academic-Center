<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompletedLesson;
use Illuminate\Http\Request;

class CompletedLessonController extends Controller
{
    // Index
    public function index()
    {
        $completedLessons = CompletedLesson::all();
        return response()->json([
            "completedLessons" => $completedLessons,
        ]);
    }

    // Check completed lesson
    public function checkCompletedLesson()
    {
        $checkCompletedLesson = CompletedLesson::where("user_id", request("userId"))
            ->where("lesson_id", request("lessonId"))
            ->first();

        if ($checkCompletedLesson) {
            CompletedLesson::where("user_id", request("userId"))
                ->where("lesson_id", request("lessonId"))
                ->delete();
            return response()->json([
                "status" => "deleted"
            ]);
        } else {
            CompletedLesson::create([
                "user_id" => request("userId"),
                "lesson_id" => request("lessonId"),
            ]);
            return response()->json([
                "status" => "completed"
            ]);
        }
    }

    // Show
    public function show()
    {
        $completedLessons = CompletedLesson::select(
            "id",
            "user_id",
            "lesson_id"
        )
            ->where("user_id", request("userId"))
            ->where("lesson_id", request("lessonId"))
            ->first();

        return response()->json([
            "completedLessons" => $completedLessons,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
