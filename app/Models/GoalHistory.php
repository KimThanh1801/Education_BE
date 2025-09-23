<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// App\Models\GoalHistory.php
use Carbon\Carbon;

class GoalHistory extends Model
{
    use HasFactory;

    protected $table = 'goal_histories';

    protected $fillable = [
        'goal_id',
        'user_id',
        'course',
        'goals',
        'courseExpectations',
        'teacherExpectations',
        'selfExpectations',
        'dueDate',
        'completeStatus',
        'semester_id',
        'action',
    ];

    // ✅ Convert về Y-m-d trước khi save
    public function setDueDateAttribute($value)
    {
        if (!$value) {
            $this->attributes['dueDate'] = null;
            return;
        }

        try {
            if (\Carbon\Carbon::hasFormat($value, 'd-m-Y')) {
                $this->attributes['dueDate'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
            } elseif (\Carbon\Carbon::hasFormat($value, 'Y-m-d')) {
                $this->attributes['dueDate'] = Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
            } else {
                $this->attributes['dueDate'] = Carbon::parse($value)->format('Y-m-d');
            }
        } catch (\Exception $e) {
            $this->attributes['dueDate'] = null;
        }
    }

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}
