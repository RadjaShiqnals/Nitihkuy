<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function signup(Request $request) {

        $request -> validate ([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:password',
        ]);

        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');

        if ($password !== $confirm_password) {
            return response()->json([
                'message' => 'Password doesn\'t match'
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return response()->json([
            'message' => 'Account created successfully',
            'user' => $user
        ]);
    }

    public function login(Request $request)
        {
            $request->validate([
                'email' => 'required|string|email|',
                'password' => 'required|string',
            ]);
    
            $credentials = $request->only('email', 'password');
            $token = JWTAuth::attempt($credentials);
    
            if (!$token) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 401);
            }
    
            $user = JWTAuth::user();
            return response()->json([
                'message' => 'User logged in successfully',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => $user->password,
                ],
                'token' => $token,
            ]);
        }
        public function getuser(){
            $dt_user=User::get();
            return response()->json($dt_user);
        }
    }