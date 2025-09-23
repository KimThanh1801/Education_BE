<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Đăng nhập người dùng
     */
  public function login(Request $request)
{
    $credentials = $request->only(['email', 'password']);

    if (!$token = auth('api')->attempt($credentials)) {
        Log::error('Login failed for:', $credentials);

        return response()->json([
            'error' => 'Email hoặc mật khẩu không đúng'
        ], 401);
    }

    $user = auth('api')->user(); // lấy thông tin user đang đăng nhập

    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth('api')->factory()->getTTL() * 60,
        'username' => $user->name,
        'role' => $user->role ?? 'student',
        'user_id' => $user->id,
    ]);
}


    /**
     * Tạo phản hồi khi đăng nhập thành công
     */
    protected function respondWithToken($token)
    {
        $user = auth('api')->user();

        return response()->json([
            'user_id'      => $user->id,
            'username'     => $user->name,
            'role'         => $user->role,
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => config('jwt.ttl') * 60
        ]);
    }

    /**
     * Đăng xuất người dùng
     */
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'success' => true,
                'message' => 'Đăng xuất thành công'
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'success' => false,
                'error'   => 'Không thể đăng xuất, token không hợp lệ'
            ], 500);
        }
    }

    /**
     * Đăng ký người dùng mới
     */
    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'errors' => $validated->errors()
            ], 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Đăng ký thành công',
            'user'    => $user
        ], 201);
    }
}
