<?php

namespace App\Http\Controllers;

use App\Models\ActionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActionLogController extends Controller
{
    // Index
    public function index()
    {
        $actionLogs =  ActionLog::select(
            "id",
            "course_id",
            "user_id",
            DB::raw("COUNT(course_id) as viewCount")
        )
            ->groupBy("course_id")
            ->orderBy("viewCount", "desc")
            ->get();
        // dd($actionLogs->toArray());
        return view("trend-course.index", compact("actionLogs"));
    }
}
