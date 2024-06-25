<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{
    /**
     * Show the login view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function loginView(): View
    {
        return view('auth.login');
    }

    /**
     * Show the registration view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function registrationView(): View
    {
        return view('auth.registration');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
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

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function userRegister(Request $request): RedirectResponse
    {  
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:email'],
            'password' => ['required', 'min:6'],
        ]);
        
        
        try {
            $this->userCreate($request->all());

            Auth::attempt($request->only('name', 'email', 'password'));
            
            $request->session()->regenerate();
            return redirect()->route('dashboard');

        } catch (QueryException $e) {
            return back()->withErrors([
                'email' => 'The email has already been taken.',
            ])->withInput();
        }
    }

    /**
     * Create a new user (Insert into the Database).
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function userCreate(array $data): User
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signOut():RedirectResponse 
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }
}