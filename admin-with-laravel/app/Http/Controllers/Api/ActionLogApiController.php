<?php

namespace App\Http\Controllers\Api;

use App\Models\ActionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ActionLogApiController extends Controller
{
    // Index
    public function index()
    {
        $actionLogs = ActionLog::select(
            "courses.id as courseId",
            "course_title",
            "course_description",
            "course_price",
            DB::raw("COUNT(DISTINCT action_logs.user_id) as userCount")
        )
            ->leftJoin("courses", "courses.id", "action_logs.course_id")
            ->leftJoin("users", "users.id", "action_logs.user_id")
            ->groupBy("courses.id", "course_title", "course_description", "course_price")
            ->get();

        return response()->json([
            "actionLogs" => $actionLogs,
        ]);
    }

    // Store
    public function store()
    {
        $actionLogs = ActionLog::create([
            "user_id" => request("userId"),
            "course_id" => request("courseId"),
        ]);
        return response()->json([
            "actionLogs" => $actionLogs,
        ]);
    }
}
