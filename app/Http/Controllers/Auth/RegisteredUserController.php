<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    // Show the “Register” form
    public function create()
    {
        return view('auth.register');
    }

    // Handle the form POST
    public function store(Request $request)
    {
        // 1) Validate
        $request->validate([
            'name'                  => ['required','string','max:255'],
            'email'                 => ['required','email','max:255','unique:users'],
            'password'              => ['required','confirmed','min:8'],
        ]);

        // 2) Create the user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3) Log them in
        Auth::login($user);

        // 4) Redirect where you like
        return redirect()->intended('/main');
    }
}
