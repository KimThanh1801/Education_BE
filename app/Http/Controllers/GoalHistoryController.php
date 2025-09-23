<?php

namespace App\Http\Controllers;

use App\Models\GoalHistory;
use App\Models\Goal;
use Illuminate\Http\Request;

class GoalHistoryController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'goal_id' => 'required|exists:goals,id',
        'action' => 'required|string',
    ]);

    // Lấy dữ liệu hiện tại của goal
    $goal = Goal::findOrFail($request->goal_id);

    // Lưu snapshot vào goal_histories
    $history = GoalHistory::create([
        'goal_id'             => $goal->id,
        'user_id'             => $goal->user_id,
        'course'              => $goal->course,
        'goals'               => $goal->goals,
        'courseExpectations'  => $goal->courseExpectations,
        'teacherExpectations' => $goal->teacherExpectations,
        'selfExpectations'    => $goal->selfExpectations,
        'dueDate'             => $goal->dueDate,
        'completeStatus'      => $goal->completeStatus,
        'semester_id'         => $goal->semester_id,
        'action'              => $request->action,
    ]);

    return response()->json($history);
}


    // **Phương thức mới: trả goal kèm lịch sử**
   public function getGoalWithHistory($goalId)
{
    $goal = Goal::with('user')->find($goalId);
    if (!$goal) {
        return response()->json(['message' => 'Goal not found'], 404);
    }

    $history = GoalHistory::where('goal_id', $goalId)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'goal' => $goal,
        'history' => $history,
    ]);
}

}
