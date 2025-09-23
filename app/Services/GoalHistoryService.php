<?php

namespace App\Services;

use App\Models\Goal;
use App\Models\GoalHistory;

class GoalHistoryService
{
public function addHistory($request)
{
    return GoalHistory::create([
        'goal_id' => $request->goal_id,
        'user_id' => $request->user_id,
        'course' => $request->course,
        'goals' => $request->goals,
        'courseExpectations' => $request->courseExpectations,
        'teacherExpectations' => $request->teacherExpectations,
        'selfExpectations' => $request->selfExpectations,
'dueDate' => $request->dueDate,        'completeStatus' => $request->completeStatus,
        'semester_id' => $request->semester_id,
        'action' => $request->action,
    ]);
}


    public function getHistoryByGoalId(int $goalId)
    {
        return GoalHistory::where('goal_id', $goalId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
