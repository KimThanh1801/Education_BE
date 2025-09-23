<?php

namespace App\Http\Controllers;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    public function getStudents()
    {
        try {
            $students = $this->service->index();

            return response()->json([
                'status' => 'success',
                'data' => $students
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch students.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getTeachers()
    {
        try {
            $teachers = $this->service->getTeachers();

            return response()->json([
                'status' => 'success',
                'data' => $teachers
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch teachers.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

   public function updateAvatar(Request $request)
{
    if (!auth()->check()) {
        return response()->json([
            'message' => 'Unauthenticated.'
        ], 401);
    }

    $user = auth()->user();

    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Xoá ảnh cũ nếu có
    if ($user->image) {
        Storage::disk('public')->delete($user->image);
    }

    $path = $request->file('image')->store('avatars', 'public');
    $user->image = $path;
    $user->save();

    return response()->json([
        'message' => 'Avatar updated successfully.',
        'image_url' => asset('storage/' . $path),
    ]);
}

}
