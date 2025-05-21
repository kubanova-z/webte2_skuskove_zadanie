<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Log in a user and start a session.
     *
     * @OA\Post(
     *   path="/api/login",
     *   tags={"Auth"},
     *   summary="Authenticate user credentials",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *       @OA\Property(property="password", type="string", format="password", example="secret123")
     *     )
     *   ),
     *   @OA\Response(
     *     response=302,
     *     description="Redirect to dashboard on success"
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Invalid credentials"
     *   )
     * )
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Log out the current user and invalidate the session.
     *
     * @OA\Post(
     *   path="/api/logout",
     *   tags={"Auth"},
     *   summary="End the authenticated session",
     *   @OA\Response(
     *     response=302,
     *     description="Redirect to home page"
     *   )
     * )
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
