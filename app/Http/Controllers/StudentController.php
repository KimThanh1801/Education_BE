<?php
// app/Http/Controllers/StudentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;

class StudentController extends Controller
{
    public function update(Request $request, $userId)
    {
        try {
            $student = Student::with('user')->where('user_id', $userId)->firstOrFail();
            $user = $student->user;

            $data = $request->validate([
                'name' => 'nullable|string|max:255',
                'image' => 'nullable|string', // base64, nên dùng longText trong migration
                'major' => 'nullable|string|max:255',
                'studentId' => 'nullable|string|max:50|unique:students,studentId,' . $student->id . ',id',
                'year' => 'nullable|string|max:50',
                'enrollDate' => 'nullable|date',
            ]);

            if (isset($data['name']))
                $user->name = $data['name'];
            if (isset($data['image']))
                $user->image = $data['image'];
            $user->save();

            if (isset($data['major']))
                $student->major = $data['major'];
         if (isset($data['studentId']))
    $student->studentId = $data['studentId'];
            if (isset($data['year']))
                $student->year = $data['year'];
            if (isset($data['enrollDate']))
    $student->enrollDate = $data['enrollDate'];
            $student->save();


            return response()->json([
                'message' => 'Student updated successfully',
                'student' => $student->load('user'),
            ]);
        } catch (\Exception $e) {
            \Log::error('Student update failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'message' => 'Update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
