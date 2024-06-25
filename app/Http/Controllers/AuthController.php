<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Views
    public function loginView(): View
    {
        return view('auth.login');
    }

    public function registrationView(): View
    {
        return view('auth.registration');
    }

    //Post Routes
    public function userLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        if (Auth::attempt($credentials)) {            
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function userRegister(Request $request): RedirectResponse
    {  
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'password' => ['required', 'min:6'], //Alternative: 'required|min:6'
        ]);
        
        $check = $this->userCreate($request->all());
        return redirect("login");
    }

    //Database Modification Functions
    public function userCreate(array $data): User
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }

    public function signOut() {
        Auth::logout();
        return Redirect('login');
    }
}