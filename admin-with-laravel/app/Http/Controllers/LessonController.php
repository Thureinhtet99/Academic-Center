<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    // Index
    public function index()
    {
        $lessons = Lesson::select(
            "lessons.id",
            "course_id",
            "lesson_name",
            "lesson_description",
            "lesson_video",
            "lessons.created_at as lessonCreated_at",
            "courses.course_title",
        )
            ->leftJoin("courses", "courses.id", "lessons.course_id")
            ->when(request('search'), function ($query) {
                $query->orWhere("lessons.lesson_name", "like", "%" . request('search') . "%");
            })
            ->orderBy("lessons.id", "desc")
            ->paginate(5);

        $lessons->appends(request()->all());
        return view("lesson.index", compact("lessons"));
    }

    // CreateIndex
    public function createIndex()
    {
        $courses = Course::select("id", "course_title")->get();
        return view("lesson.createIndex", compact("courses"));
    }

    // Create
    public function create()
    {
        $this->createValidationCheck();
        $formDatas = $this->createFormData();

        if (request()->hasFile("lessonVideo")) {
            $videoName = uniqid() . request()->file("lessonVideo")->getClientOriginalName();
            request()->file("lessonVideo")->storeAs("public", $videoName);
            $formDatas["lesson_video"] = $videoName;
        } else {
            $formDatas["lesson_video"] = null;
        }
        $item = Lesson::create($formDatas);
        return redirect()->route('lesson.index');
    }


    // Edit
    public function edit($id)
    {
        $lessons = Lesson::select(
            "lessons.id",
            "course_id",
            "lesson_name",
            "lesson_description",
            "lesson_video",
        )
            ->leftJoin("courses", "courses.id", "lessons.course_id")
            ->where("lessons.id", $id)
            ->first();
        $courses = Course::select("id", "course_title")->get();
        return view("lesson.edit", compact("lessons", "courses"));
    }

    // Update
    public function update($id)
    {
        $this->updateValidationCheck();
        $formDatas = $this->createFormData();

        if (request()->hasFile("lessonVideo")) {
            $video = Lesson::where("id", $id)->first();
            $video = $video->lessonVideo;

            if ($video != null) {
                Storage::delete("public/$video");
            }

            $videoName = uniqid() . request()->file("lessonVideo")->getClientOriginalName();
            request()->file("lessonVideo")->storeAs("public", $videoName);
            $formDatas["lesson_video"] = $videoName;
        }

        Lesson::where("id", $id)->update($formDatas);
        return redirect()->route('lesson.index')->with(["updateSuccess" => "Update Success"]);
    }

    // Delete
    public function delete($id)
    {
        Lesson::where("id", $id)->delete();
        return redirect()->route('lesson.index')->with(["deleteSuccess" => "Delete Success"]);
    }

    //  PRIVATE
    private function createFormData()
    {
        return [
            "course_id" => request("courseName"),
            "lesson_name" => request("name"),
            "lesson_description" => request("description"),
        ];
    }

    // Validation
    private function createValidationCheck()
    {
        $validationRules = [
            "courseName" => "required",
            "name" => "required",
            "description" => "required",
            "lessonVideo" => "required|mimes:mp4|file",
            // |max:100000 => adjust video size
        ];
        return Validator::make(request()->all(), $validationRules)->validate();
    }

    private function updateValidationCheck()
    {
        $validationRules = [
            "courseName" => "required",
            "name" => "required",
            // "name" => "required|unique:lessons,lesson_name," . request("id"),
            "description" => "required",
            "lessonVideo" => "mimes:mp4|file",
            // |max:100000 => adjust video size
        ];
        return Validator::make(request()->all(), $validationRules)->validate();
    }
}
