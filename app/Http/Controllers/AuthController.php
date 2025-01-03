<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use HasFactory, Notifiable, HasApiTokens;

class AuthController extends Controller
{
    //Register a new User
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'user_id' => uniqid(),
            'key' => bin2hex(random_bytes(8)),
            'status' => 'offline',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return redirect()->route('home')->with('success', 'Registration successful!');
    }

    // Login an existing User
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return redirect()->route('home')->with('success', 'Login successful!');
    }

    // Logout User
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
