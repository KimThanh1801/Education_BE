<?php

namespace App\Repositories;
use App\Models\User;

class UserRepository
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

public function getStudents()
{
   return User::where('role', 'student')
    ->join('students', 'users.id', '=', 'students.user_id')
    ->select(
        'users.id',
        'users.name',
        'users.image',
        'students.major',
        'students.year',
        'students.studentId',
        'students.enrollDate'
    )
    ->get();

}


    public function getUserId($name)
    {
        $user = User::where('name', $name)->first();
        return $user?->id;
    }

    public function createUser($data)
    {
        $user = User::create($data);
        return $user;
    }

    public function existUser($email)
    {
        return User::where('email', $email)->exists();
    }

    public function getTeachers()
    {
        $teachers = User::where('role', '=', 'teacher')->get();
        return $teachers;
    }
}