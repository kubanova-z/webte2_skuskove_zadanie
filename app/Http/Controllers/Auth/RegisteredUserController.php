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


    /**
     * Register a new user.
     *
     * @OA\Post(
     *   path="/api/register",
     *   tags={"Auth"},
     *   summary="Create a new user account",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"name","email","password","password_confirmation"},
     *       @OA\Property(property="name", type="string", example="Jane Doe"),
     *       @OA\Property(property="email", type="string", format="email", example="jane@example.com"),
     *       @OA\Property(property="password", type="string", format="password", example="secret123"),
     *       @OA\Property(property="password_confirmation", type="string", format="password", example="secret123")
     *     )
     *   ),
     *   @OA\Response(
     *     response=302,
     *     description="Redirects to the main page on success"
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="Validation error"
     *   )
     * )
     */
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