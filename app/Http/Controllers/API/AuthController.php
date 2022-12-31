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

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(auth()->attempt($request->all())) {
            return response([
                'status' => 'success',
                'user' => auth()->user(),
                'access_token' => Auth::user()->createToken('authToken'),
            ], Response::HTTP_OK);
        }


        return response([
            'status' => 'error',
            'message' => 'This User does not exist'
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
            'password' => Hash::make($request->password)
        ]);

        return response(['user' => $user], Response::HTTP_CREATED);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->delete();

        return response([
            'status' => 'success',
            'message' => 'You have been successfully logged out!'
        ], Response::HTTP_OK);
    }
}
