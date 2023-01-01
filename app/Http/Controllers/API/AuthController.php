<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rules;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(auth()->attempt($request->all())) {
            Auth::setUser(auth()->user());

            if(User::where('is_admin', 1)->where('id', auth()->user()->id)->exists()) {
                return response()->json([
                    'role' => 'admin',
                    'token' => auth()->user()->createToken('admin')->plainTextToken,
                    'user' => auth()->user()
                ], Response::HTTP_OK);
            } else {
                return response([
                    'status' => 'success',
                    'user' => auth()->user(),
                    'access_token' => auth()->user()->createToken('authToken'),
                ], Response::HTTP_OK);
            }
        }

        return response([
            'status' => 'error',
            'message' => 'This user does not exist',
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|unique:users',
            'password' => ['required']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response(['user' => $user], Response::HTTP_CREATED);
    }

    public function logout()
    {
//        auth()->user()->tokens()->delete();

        return response([
            'status' => 'success',
            'message' => 'You have been successfully logged out!'
        ], Response::HTTP_OK);
    }
}
