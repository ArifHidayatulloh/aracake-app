<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }


    public function register()
    {
        return view('auth.register');
    }

    public function loginAction(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // dd($user);
            if ($user->role === UserRole::Customer) {
                return redirect()->route('home');
            } elseif ($user->role === UserRole::Admin) { // Periksa peran admin secara eksplisit
                return redirect()->route('admin.dashboard');
            }
        }

        return redirect()->back()->with('error', 'Email atau password salah');
    }
    public function registerProcess(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ]);

        $validatedData['role'] = 'customer';
        $validatedData['password'] = bcrypt($validatedData['password']);

        try {
            User::create([
                'full_name' => $validatedData['full_name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'phone_number' => $validatedData['phone_number'],
                'password' => $validatedData['password'],
            ]);

            return redirect()->route('login')->with('success', 'Registrasi berhasil');
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
