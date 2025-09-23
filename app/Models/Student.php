<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
public $timestamps = false;
    protected $fillable = [
        'user_id',
        'major',
        'year',
        'studentId',
        'enrollDate',
        'gpa',
        'subjects',
        'achievements',
        'activities',
        'progress',
        'highlights',
    ];

    protected $casts = [
        'enrollDate' => 'date',
    ];

    // Thêm quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
